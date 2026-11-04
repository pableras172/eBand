/**
 * eBand Mobile Controller
 * Soporte: Onboarding, WebView, OneSignal Push, Biometría, Cámara y Navegación
 */

// URL del dominio central de producción de eBand
const DEFAULT_CENTRAL_API = 'https://eband.app';

class EBandMobileApp {
  constructor() {
    this.currentResolvedTenant = null;
    this.pendingDestinationUrl = null;
    this.centralApiBase = this.detectCentralApiBase();
    this.log(`Iniciado eBand Mobile. API Central: ${this.centralApiBase}`);
  }

  detectCentralApiBase() {
    if (!window.Capacitor?.isNativePlatform?.() && window.location.port === '8000') {
      return window.location.origin;
    }
    return DEFAULT_CENTRAL_API;
  }

  log(message, data = null) {
    const timestamp = new Date().toLocaleTimeString();
    const tag = '[EBAND_DEBUG]';
    if (data) {
      console.log(`${tag} [${timestamp}] ${message}`, data);
    } else {
      console.log(`${tag} [${timestamp}] ${message}`);
    }

    const debugBox = document.getElementById('debug-log');
    if (debugBox) {
      debugBox.style.display = 'block';
      const line = document.createElement('div');
      line.textContent = data ? `[${timestamp}] ${message}: ${JSON.stringify(data)}` : `[${timestamp}] ${message}`;
      debugBox.appendChild(line);
      debugBox.scrollTop = debugBox.scrollHeight;
    }
  }

  get Preferences() {
    return window.Capacitor?.Plugins?.Preferences || {
      get: async ({ key }) => ({ value: localStorage.getItem(key) }),
      set: async ({ key, value }) => localStorage.setItem(key, value),
      remove: async ({ key }) => localStorage.removeItem(key),
      clear: async () => localStorage.clear(),
    };
  }

  get Network() {
    return window.Capacitor?.Plugins?.Network;
  }

  get App() {
    return window.Capacitor?.Plugins?.App;
  }

  get Browser() {
    return window.Capacitor?.Plugins?.Browser;
  }

  get Camera() {
    return window.Capacitor?.Plugins?.Camera;
  }

  get NativeBiometric() {
    return window.Capacitor?.Plugins?.NativeBiometric;
  }

  async init() {
    this.initNetworkListener();
    this.initAppNavigationListener();

    // 1. Comprobar si ya existe una agrupación configurada previamente
    try {
      this.log('Comprobando configuración previa guardada...');
      const { value: tenantUrl } = await this.Preferences.get({ key: 'eband_tenant_url' });
      const { value: onesignalAppId } = await this.Preferences.get({ key: 'eband_onesignal_app_id' });
      const { value: tenantId } = await this.Preferences.get({ key: 'eband_tenant_id' });

      // Si hay OneSignal configurado, inicializarlo
      if (onesignalAppId) {
        this.initOneSignal(onesignalAppId, tenantId);
      }

      if (tenantUrl && tenantUrl.startsWith('http')) {
        this.log(`Agrupación encontrada: ${tenantUrl}.`);
        this.pendingDestinationUrl = tenantUrl;

        // Comprobar si la biometría está activada o disponible
        const biometricAuthPassed = await this.checkAndPromptBiometrics();
        if (biometricAuthPassed) {
          this.log(`Redirigiendo a: ${tenantUrl}`);
          window.location.replace(tenantUrl);
          return;
        } else {
          this.showBiometricScreen();
          return;
        }
      }
      this.log('No hay agrupación guardada. Mostrando pantalla de código.');
    } catch (err) {
      this.log('Aviso al leer configuración previa', err?.message || err);
    }

    const codeInput = document.getElementById('band-code');
    if (codeInput) {
      codeInput.focus();
    }
  }

  /* -------------------------------------------------------------------------- */
  /*  1. NOTIFICACIONES PUSH (OneSignal)                                         */
  /* -------------------------------------------------------------------------- */
  initOneSignal(appId, tenantId = null) {
    if (window.plugins?.OneSignal && appId) {
      try {
        this.log(`Inicializando OneSignal con App ID: ${appId}`);
        window.plugins.OneSignal.initialize(appId);
        window.plugins.OneSignal.Notifications.requestPermission(true);
        if (tenantId) {
          window.plugins.OneSignal.User.addTag('tenant_id', tenantId);
        }
      } catch (e) {
        this.log('Aviso inicializando OneSignal:', e?.message || e);
      }
    }
  }

  /* -------------------------------------------------------------------------- */
  /*  2. NAVEGACIÓN NATIVA Y BOTÓN ATRÁS                                        */
  /* -------------------------------------------------------------------------- */
  initAppNavigationListener() {
    if (this.App) {
      this.App.addListener('backButton', ({ canGoBack }) => {
        if (canGoBack || window.history.length > 1) {
          window.history.back();
        } else {
          this.App.exitApp();
        }
      });
    }

    // Interceptar clics en enlaces externos si los hubiera
    document.addEventListener('click', (event) => {
      const target = event.target.closest('a');
      if (target && target.href) {
        const url = new URL(target.href);
        const isExternal = !url.hostname.includes('eband.app') && 
                           !url.hostname.includes('eband.es') && 
                           !url.hostname.includes('localhost');
        if (isExternal) {
          event.preventDefault();
          this.openExternalUrl(target.href);
        }
      }
    });
  }

  async openExternalUrl(url) {
    if (this.Browser) {
      await this.Browser.open({ url });
    } else {
      window.open(url, '_blank');
    }
  }

  /* -------------------------------------------------------------------------- */
  /*  3. CÁMARA Y ARCHIVOS NATIVOS                                              */
  /* -------------------------------------------------------------------------- */
  async takePhoto() {
    if (!this.Camera) {
      this.log('Cámara nativa no disponible en este entorno.');
      return null;
    }
    try {
      const image = await this.Camera.getPhoto({
        quality: 90,
        allowEditing: false,
        resultType: 'uri',
        source: 'PROMPT', // Da a elegir entre tomar foto o galería
      });
      return image.webPath;
    } catch (e) {
      this.log('Aviso cancelado o error en cámara:', e?.message || e);
      return null;
    }
  }

  /* -------------------------------------------------------------------------- */
  /*  5. ACCESO BIOMÉTRICO (Huella / Face ID)                                   */
  /* -------------------------------------------------------------------------- */
  async checkAndPromptBiometrics() {
    if (!this.NativeBiometric) {
      return true; // No está en entorno nativo o plugin no cargado
    }

    try {
      const { value: biometricEnabled } = await this.Preferences.get({ key: 'eband_biometric_enabled' });
      // Si el usuario no lo ha activado explícitamente, no bloquear
      if (biometricEnabled !== 'true') {
        return true;
      }

      const available = await this.NativeBiometric.isAvailable();
      if (!available?.isAvailable) {
        return true;
      }

      this.log('Solicitando verificación biométrica...');
      await this.NativeBiometric.verifyIdentity({
        reason: 'Identifícate con tu huella o rostro para acceder a eBand',
        title: 'Acceso seguro',
        subtitle: 'eBand',
        description: 'Usa la biometría de tu dispositivo',
      });

      this.log('Biometría verificada con éxito.');
      return true;
    } catch (error) {
      this.log('Autenticación biométrica no completada o cancelada.');
      return false;
    }
  }

  showBiometricScreen() {
    const biometricScreen = document.getElementById('biometric-screen');
    if (biometricScreen) {
      biometricScreen.style.display = 'flex';
    }
  }

  async retryBiometrics() {
    const passed = await this.checkAndPromptBiometrics();
    if (passed && this.pendingDestinationUrl) {
      const biometricScreen = document.getElementById('biometric-screen');
      if (biometricScreen) {
        biometricScreen.style.display = 'none';
      }
      window.location.replace(this.pendingDestinationUrl);
    }
  }

  async toggleBiometrics(enable) {
    await this.Preferences.set({ key: 'eband_biometric_enabled', value: enable ? 'true' : 'false' });
    this.log(`Biometría configurada como: ${enable ? 'activada' : 'desactivada'}`);
  }

  /* -------------------------------------------------------------------------- */
  /*  RED Y CONEXIÓN                                                            */
  /* -------------------------------------------------------------------------- */
  initNetworkListener() {
    if (this.Network) {
      this.Network.addListener('networkStatusChange', (status) => {
        this.log(`Estado de red: conectado=${status.connected}`);
        const offlineScreen = document.getElementById('offline-screen');
        if (offlineScreen) {
          offlineScreen.style.display = !status.connected ? 'flex' : 'none';
        }
      });
    }

    window.addEventListener('offline', () => {
      this.log('Evento navegador: offline');
      const offlineScreen = document.getElementById('offline-screen');
      if (offlineScreen) offlineScreen.style.display = 'flex';
    });

    window.addEventListener('online', () => {
      this.log('Evento navegador: online');
      const offlineScreen = document.getElementById('offline-screen');
      if (offlineScreen) offlineScreen.style.display = 'none';
    });
  }

  async retryConnection() {
    this.log('Reintentando conexión...');
    if (navigator.onLine) {
      const offlineScreen = document.getElementById('offline-screen');
      if (offlineScreen) offlineScreen.style.display = 'none';
      if (this.currentResolvedTenant) {
        this.handleConfirmBand();
      } else {
        this.init();
      }
    }
  }

  showError(message) {
    this.log(`ERROR: ${message}`);
    const errorAlert = document.getElementById('error-alert');
    if (errorAlert) {
      errorAlert.textContent = message;
      errorAlert.style.display = 'block';
    }
  }

  clearError() {
    const errorAlert = document.getElementById('error-alert');
    if (errorAlert) {
      errorAlert.textContent = '';
      errorAlert.style.display = 'none';
    }
  }

  setLoading(isLoading) {
    const btn = document.getElementById('btn-validate');
    const spinner = document.getElementById('btn-spinner');
    const btnText = btn?.querySelector('.btn-text');

    if (btn) btn.disabled = isLoading;
    if (spinner) spinner.style.display = isLoading ? 'inline-block' : 'none';
    if (btnText) btnText.style.display = isLoading ? 'none' : 'inline-block';
  }

  async handleValidateCode() {
    this.clearError();
    const codeInput = document.getElementById('band-code');
    const rawCode = codeInput?.value || '';
    const code = rawCode.trim().toUpperCase();

    if (!code) {
      this.showError('Por favor, introduce el código de tu agrupación.');
      return;
    }

    this.setLoading(true);
    const endpoint = `${this.centralApiBase}/api/v1/mobile/tenants/resolve?code=${encodeURIComponent(code)}`;
    console.log('[EBAND_DEBUG] ========================================');
    console.log('[EBAND_DEBUG] >>> SOLICITANDO RESOLUCION DE CODIGO:', code);
    console.log('[EBAND_DEBUG] >>> URL:', endpoint);
    this.log(`Consultando API: ${endpoint}`);

    try {
      const response = await fetch(endpoint, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'X-eBand-Mobile': '1',
        },
      });

      console.log('[EBAND_DEBUG] <<< HTTP STATUS:', response.status, response.statusText);
      this.log(`Respuesta HTTP: ${response.status} ${response.statusText}`);

      const rawText = await response.text();
      console.log('[EBAND_DEBUG] <<< RAW RESPONSE RECIBIDO DEL SERVIDOR:');
      console.log(rawText);

      let json = null;

      try {
        json = JSON.parse(rawText);
      } catch (parseError) {
        console.error('[EBAND_DEBUG] ERROR PARSEANDO JSON:', parseError);
        this.log('Error parseando JSON. Contenido:', rawText.substring(0, 120));
        throw new Error(`El servidor devolvió un formato no esperado (HTTP ${response.status}).`);
      }

      console.log('[EBAND_DEBUG] <<< JSON PARSEADO EXITOSAMENTE:', json);

      if (!response.ok || !json.success) {
        throw new Error(json.message || `No se encontró la agrupación (HTTP ${response.status})`);
      }

      console.log('[EBAND_DEBUG] Detalle de agrupación recibido:');
      console.log('[EBAND_DEBUG] - ID Tenant:', json.data?.tenant_id);
      console.log('[EBAND_DEBUG] - Nombre completo:', json.data?.name);
      console.log('[EBAND_DEBUG] - Nombre corto:', json.data?.short_name);
      console.log('[EBAND_DEBUG] - Logo URL:', json.data?.logo_url);
      console.log('[EBAND_DEBUG] - Dirección:', json.data?.direccion);
      console.log('[EBAND_DEBUG] - Web:', json.data?.website);
      console.log('[EBAND_DEBUG] - Redes sociales:', json.data?.social);
      console.log('[EBAND_DEBUG] ========================================');

      this.log('Agrupación resuelta:', json.data);
      this.currentResolvedTenant = json.data;
      this.showPreview(json.data);
    } catch (err) {
      console.error('[EBAND_DEBUG] Error en handleValidateCode:', err);
      this.showError(err.message || 'Error de conexión con el servidor de eBand.');
    } finally {
      this.setLoading(false);
    }
  }

  showPreview(tenant) {
    console.log('[EBAND_DEBUG] Ejecutando showPreview con:', tenant);
    document.getElementById('step-code').style.display = 'none';
    const previewSection = document.getElementById('step-confirm');
    const previewLogo = document.getElementById('preview-logo');
    const previewName = document.getElementById('preview-name');
    const previewLocation = document.getElementById('preview-location');
    const previewCode = document.getElementById('preview-code');
    const socialLinks = document.getElementById('social-links');

    previewName.textContent = tenant.name || 'Sin nombre';
    previewCode.textContent = tenant.code || '';

    // Dirección / Localidad
    if (tenant.direccion) {
      previewLocation.textContent = tenant.direccion;
      previewLocation.style.display = 'block';
    } else {
      previewLocation.style.display = 'none';
    }

    // Logo de la banda o fallback al logo oficial eBand
    previewLogo.onerror = () => {
      console.warn('[EBAND_DEBUG] Error al cargar imagen del logo:', tenant.logo_url, '. Usando fallback.');
      previewLogo.src = 'img/logo.png';
    };
    previewLogo.onload = () => {
      console.log('[EBAND_DEBUG] Logo cargado con éxito en el elemento <img>:', previewLogo.src);
    };

    if (tenant.logo_url) {
      console.log('[EBAND_DEBUG] Asignando src a previewLogo:', tenant.logo_url);
      previewLogo.src = tenant.logo_url;
      previewLogo.style.display = 'block';
    } else {
      console.log('[EBAND_DEBUG] No hay logo_url, usando logo local img/logo.png');
      previewLogo.src = 'img/logo.png';
      previewLogo.style.display = 'block';
    }

    // Iconos de redes sociales y web
    let hasSocial = false;
    const bindSocial = (btnId, url) => {
      const btn = document.getElementById(btnId);
      if (btn) {
        if (url) {
          btn.style.display = 'inline-flex';
          btn.onclick = () => this.openExternalUrl(url);
          hasSocial = true;
        } else {
          btn.style.display = 'none';
          btn.onclick = null;
        }
      }
    };

    bindSocial('social-web', tenant.website);
    bindSocial('social-instagram', tenant.social?.instagram);
    bindSocial('social-facebook', tenant.social?.facebook);
    bindSocial('social-tiktok', tenant.social?.tiktok);

    if (socialLinks) {
      socialLinks.style.display = hasSocial ? 'flex' : 'none';
    }

    previewSection.style.display = 'block';
  }

  handleCancelPreview() {
    this.currentResolvedTenant = null;
    document.getElementById('step-confirm').style.display = 'none';
    document.getElementById('step-code').style.display = 'block';
    this.clearError();
  }

  async handleConfirmBand() {
    if (!this.currentResolvedTenant) {
      return;
    }

    const { target_url, login_url, code, name, logo_url, onesignal_app_id, tenant_id } = this.currentResolvedTenant;
    this.log(`Guardando configuración de banda: ${name} (${code})`);

    try {
      await this.Preferences.set({ key: 'eband_tenant_code', value: code });
      await this.Preferences.set({ key: 'eband_tenant_url', value: target_url });
      await this.Preferences.set({ key: 'eband_tenant_name', value: name });
      if (tenant_id) {
        await this.Preferences.set({ key: 'eband_tenant_id', value: tenant_id });
      }
      if (logo_url) {
        await this.Preferences.set({ key: 'eband_logo_url', value: logo_url });
      }
      if (onesignal_app_id) {
        await this.Preferences.set({ key: 'eband_onesignal_app_id', value: onesignal_app_id });
        this.initOneSignal(onesignal_app_id, tenant_id);
      }

      const destination = login_url || target_url;
      this.log(`Navegando a: ${destination}`);
      window.location.replace(destination);
    } catch (err) {
      this.showError('No se pudo guardar la configuración en el dispositivo.');
    }
  }

  async desvincularBanda() {
    try {
      await this.Preferences.clear();
      this.currentResolvedTenant = null;
      window.location.replace('index.html');
    } catch (err) {
      console.error('Error desvinculando banda:', err);
    }
  }
}

// Inicializar la app al cargar el DOM
window.app = new EBandMobileApp();
document.addEventListener('DOMContentLoaded', () => {
  window.app.init();
});
