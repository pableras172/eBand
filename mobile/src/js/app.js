/**
 * eBand Mobile Controller
 */

// URL del dominio central de eBand
const DEFAULT_CENTRAL_API = 'https://eband.app';

class EBandMobileApp {
  constructor() {
    this.currentResolvedTenant = null;
    this.centralApiBase = this.detectCentralApiBase();
  }

  detectCentralApiBase() {
    // Si estamos en desarrollo local en navegador
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
      return window.location.origin;
    }
    return DEFAULT_CENTRAL_API;
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

  async init() {
    this.initNetworkListener();

    // Comprobar si ya existe una agrupación configurada previamente
    try {
      const { value: tenantUrl } = await this.Preferences.get({ key: 'eband_tenant_url' });
      if (tenantUrl && tenantUrl.startsWith('http')) {
        // Redirigir directamente al WebView del tenant
        window.location.replace(tenantUrl);
        return;
      }
    } catch (err) {
      console.warn('Error reading preferences:', err);
    }

    // Inicializar listeners de UI
    const codeInput = document.getElementById('band-code');
    if (codeInput) {
      codeInput.focus();
    }
  }

  initNetworkListener() {
    if (this.Network) {
      this.Network.addListener('networkStatusChange', (status) => {
        const offlineScreen = document.getElementById('offline-screen');
        if (!status.connected) {
          offlineScreen.style.display = 'flex';
        } else {
          offlineScreen.style.display = 'none';
        }
      });
    }

    window.addEventListener('offline', () => {
      document.getElementById('offline-screen').style.display = 'flex';
    });
    window.addEventListener('online', () => {
      document.getElementById('offline-screen').style.display = 'none';
    });
  }

  async retryConnection() {
    if (navigator.onLine) {
      document.getElementById('offline-screen').style.display = 'none';
      if (this.currentResolvedTenant) {
        this.handleConfirmBand();
      } else {
        this.init();
      }
    }
  }

  showError(message) {
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

    if (btn) {
      btn.disabled = isLoading;
    }
    if (spinner) {
      spinner.style.display = isLoading ? 'inline-block' : 'none';
    }
    if (btnText) {
      btnText.style.display = isLoading ? 'none' : 'inline-block';
    }
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

    try {
      const endpoint = `${this.centralApiBase}/api/v1/mobile/tenants/resolve?code=${encodeURIComponent(code)}`;
      const response = await fetch(endpoint, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'X-eBand-Mobile': '1',
        },
      });

      const json = await response.json();

      if (!response.ok || !json.success) {
        throw new Error(json.message || 'Código de agrupación no encontrado.');
      }

      this.currentResolvedTenant = json.data;
      this.showPreview(json.data);
    } catch (err) {
      this.showError(err.message || 'Error al conectar con el servidor.');
    } finally {
      this.setLoading(false);
    }
  }

  showPreview(tenant) {
    document.getElementById('step-code').style.display = 'none';
    const previewSection = document.getElementById('step-confirm');
    const previewLogo = document.getElementById('preview-logo');
    const previewName = document.getElementById('preview-name');
    const previewCode = document.getElementById('preview-code');

    previewName.textContent = tenant.name;
    previewCode.textContent = tenant.code;
    
    // Logo o fallback
    if (tenant.logo_url) {
      previewLogo.src = tenant.logo_url;
      previewLogo.style.display = 'block';
    } else {
      previewLogo.src = 'data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'><circle cx=\'50\' cy=\'50\' r=\'45\' fill=\'%232563eb\'/><text x=\'50\' y=\'62\' font-size=\'40\' font-family=\'sans-serif\' font-weight=\'bold\' fill=\'white\' text-anchor=\'middle\'>🎵</text></svg>';
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

    const { target_url, login_url, code, name, logo_url } = this.currentResolvedTenant;

    try {
      // Guardar de forma persistente en el dispositivo
      await this.Preferences.set({ key: 'eband_tenant_code', value: code });
      await this.Preferences.set({ key: 'eband_tenant_url', value: target_url });
      await this.Preferences.set({ key: 'eband_tenant_name', value: name });
      if (logo_url) {
        await this.Preferences.set({ key: 'eband_logo_url', value: logo_url });
      }

      // Redirigir al login o entrada del tenant
      const destination = login_url || target_url;
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
