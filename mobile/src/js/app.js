/**
 * eBand Mobile Controller
 * Soporte: Onboarding, Multidioma (ES/VAL/EN), Modo Día/Noche, Escáner QR, Demo Band,
 * Píldoras de Valor, WebView, OneSignal Push, Biometría, Cámara y Navegación
 */

// URL del dominio central de producción de eBand
const DEFAULT_CENTRAL_API = 'https://eband.app';

// Diccionario de Traducciones (Castellano, Valenciano, Inglés)
const TRANSLATIONS = {
  es: {
    subtitle: 'Tu agrupación musical siempre contigo',
    code_label: 'Código de tu agrupación',
    code_placeholder: 'EJ: BANDA-VALENCIA',
    btn_continue: 'Continuar',
    btn_scan_qr: 'Escanear Código QR',
    btn_scan_gallery: 'Escanear desde foto o galería',
    divider_or: 'o bien',
    btn_demo: 'Probar Banda Demo',
    btn_demo_sub: 'Explora una banda de ejemplo sin registrarte',
    help_link: '¿No sabes el código de tu agrupación?',
    not_registered_title: '¿Tu banda aún no usa eBand?',
    not_registered_desc: 'Gestiona actividades, asistencias, convocatorias y avisos inmediatos para tus músicos.',
    btn_more_info: 'Solicitar información / Registrar banda',
    pill_activities_title: 'Actividades',
    pill_activities_desc: 'Ensayos, conciertos y actuaciones',
    pill_attendance_title: 'Asistencias',
    pill_attendance_desc: 'Confirmación y control en tiempo real',
    pill_communication_title: 'Comunicación',
    pill_communication_desc: 'Avisos y notificaciones al móvil',
    help_modal_title: '¿Dónde encuentro mi código?',
    help_modal_p1: 'El código de agrupación es un identificador único asignado a cada sociedad musical o banda registrada en eBand.',
    help_modal_step1: '<strong>Consulta a tu directiva o secretaría:</strong> Ellos tienen el código oficial de acceso para los músicos.',
    help_modal_step2: '<strong>Revisa tu correo de bienvenida:</strong> Si recibiste una invitación de eBand, el código aparece indicado en el mensaje.',
    help_modal_step3: '<strong>¿Eres director o responsable?</strong> Si tu banda aún no está en eBand, puedes solicitar el alta y comenzar a probarla hoy mismo.',
    help_modal_close: 'Entendido',
    qr_modal_title: 'Escanear Código QR',
    qr_modal_desc: 'Enfoca el código QR de tu banda',
    qr_camera_error: 'No se pudo iniciar la cámara. Comprueba los permisos en los ajustes del dispositivo.',
    qr_not_found_in_image: 'No se encontró ningún código QR en la imagen seleccionada.',
    access_band: 'Acceder a mi banda',
    enter_other_code: 'Introducir otro código',
    offline_title: 'Sin conexión a internet',
    offline_desc: 'Comprueba tu conexión Wi-Fi o datos móviles para continuar usando eBand.',
    btn_retry: 'Reintentar conexión',
    biometric_title: 'Acceso protegido',
    biometric_desc: 'Identifícate con tu huella o rostro para continuar a tu agrupación.',
    btn_unlock: 'Desbloquear con Biometría',
    error_empty_code: 'Por favor, introduce el código de tu agrupación.',
    error_network: 'Error de conexión con el servidor de eBand.',
    error_saving: 'No se pudo guardar la configuración en el dispositivo.',
    error_invalid_response: 'El servidor devolvió un formato no esperado.',
  },
  va: {
    subtitle: 'La teua agrupació musical sempre amb tu',
    code_label: 'Codi de la teua agrupació',
    code_placeholder: 'EX: BANDA-VALENCIA',
    btn_continue: 'Continuar',
    btn_scan_qr: 'Escanar Codi QR',
    btn_scan_gallery: 'Escanar des de foto o galeria',
    divider_or: 'o bé',
    btn_demo: 'Provar Banda Demo',
    btn_demo_sub: 'Explora una agrupació d\'exemple sense registrar-te',
    help_link: 'No saps el codi de la teua agrupació?',
    not_registered_title: 'La teua banda encara no utilitza eBand?',
    not_registered_desc: 'Gestiona activitats, assistències, convocatòries i avisos immediats per als teus músics.',
    btn_more_info: 'Demanar informació / Registrar banda',
    pill_activities_title: 'Activitats',
    pill_activities_desc: 'Assajos, concerts i actuacions',
    pill_attendance_title: 'Assistències',
    pill_attendance_desc: 'Confirmació i control en temps real',
    pill_communication_title: 'Comunicació',
    pill_communication_desc: 'Avisos i notificacions al mòbil',
    help_modal_title: 'On trobe el meu codi?',
    help_modal_p1: 'El codi d\'agrupació és un identificador únic assignat a cada societat musical o banda registrada en eBand.',
    help_modal_step1: '<strong>Consulta a la teua directiva o secretaria:</strong> Ells tenen el codi oficial d\'accés per als músics.',
    help_modal_step2: '<strong>Revisa el teu correu de benvinguda:</strong> Si vas rebre una invitació d\'eBand, el codi ve indicat en el missatge.',
    help_modal_step3: '<strong>Ets director o responsable?</strong> Si la teua banda encara no està en eBand, pots sol·licitar l\'alta i començar a provar-la.',
    help_modal_close: 'Entés',
    qr_modal_title: 'Escanar Codi QR',
    qr_modal_desc: 'Enfoca el codi QR de la teua banda',
    qr_camera_error: 'No s\'ha pogut iniciar la càmera. Comprova els permisos als ajustos del dispositiu.',
    qr_not_found_in_image: 'No s\'ha trobat cap codi QR a la imatge seleccionada.',
    access_band: 'Accedir a la meua agrupació',
    enter_other_code: 'Introduir un altre codi',
    offline_title: 'Sense connexió a internet',
    offline_desc: 'Comprova la teua connexió Wi-Fi o dades mòbils per continuar utilitzant eBand.',
    btn_retry: 'Reintentar connexió',
    biometric_title: 'Accés protegit',
    biometric_desc: 'Identifica\'t amb la teua empremta o rostre per a continuar a la teua agrupació.',
    btn_unlock: 'Desbloquejar amb Biometria',
    error_empty_code: 'Per favor, introduïx el codi de la teua agrupació.',
    error_network: 'Error de connexió amb el servidor d\'eBand.',
    error_saving: 'No s\'ha pogut guardar la configuració en el dispositiu.',
    error_invalid_response: 'El servidor ha retornat un format no esperat.',
  },
  en: {
    subtitle: 'Your musical ensemble always with you',
    code_label: 'Your ensemble code',
    code_placeholder: 'E.G. BAND-NAME',
    btn_continue: 'Continue',
    btn_scan_qr: 'Scan QR Code',
    btn_scan_gallery: 'Scan from photo or gallery',
    divider_or: 'or',
    btn_demo: 'Try Demo Band',
    btn_demo_sub: 'Explore a demo band without registering',
    help_link: 'Don\'t know your ensemble code?',
    not_registered_title: 'Does your band not use eBand yet?',
    not_registered_desc: 'Manage activities, attendance, calls and instant notifications for your musicians.',
    btn_more_info: 'Request info / Register band',
    pill_activities_title: 'Activities',
    pill_activities_desc: 'Rehearsals, concerts and events',
    pill_attendance_title: 'Attendance',
    pill_attendance_desc: 'Real-time tracking and confirmation',
    pill_communication_title: 'Communication',
    pill_communication_desc: 'Instant announcements and push alerts',
    help_modal_title: 'Where do I find my code?',
    help_modal_p1: 'The ensemble code is a unique identifier assigned to each music society or band registered on eBand.',
    help_modal_step1: '<strong>Ask your board of directors or secretary:</strong> They have the official access code for musicians.',
    help_modal_step2: '<strong>Check your welcome email:</strong> If you received an invitation from eBand, the code is specified in the message.',
    help_modal_step3: '<strong>Are you a director or manager?</strong> If your band is not yet on eBand, you can request registration and try it out today.',
    help_modal_close: 'Got it',
    qr_modal_title: 'Scan QR Code',
    qr_modal_desc: 'Point your camera at your band\'s QR code',
    qr_camera_error: 'Could not access the camera. Please check app permissions in system settings.',
    qr_not_found_in_image: 'No QR code was found in the selected image.',
    access_band: 'Access my band',
    enter_other_code: 'Enter another code',
    offline_title: 'No internet connection',
    offline_desc: 'Check your Wi-Fi or mobile data connection to continue using eBand.',
    btn_retry: 'Retry connection',
    biometric_title: 'Protected access',
    biometric_desc: 'Authenticate with your fingerprint or face to proceed to your ensemble.',
    btn_unlock: 'Unlock with Biometrics',
    error_empty_code: 'Please enter your ensemble code.',
    error_network: 'Connection error with eBand server.',
    error_saving: 'Could not save configuration on device.',
    error_invalid_response: 'The server returned an unexpected format.',
  }
};

class EBandMobileApp {
  constructor() {
    this.currentResolvedTenant = null;
    this.pendingDestinationUrl = null;
    this.currentLanguage = 'es';
    this.currentTheme = 'auto'; // 'auto' | 'light' | 'dark'
    this.qrStream = null;
    this.qrScanActive = false;
    this.barcodeDetector = null;
    this.centralApiBase = this.detectCentralApiBase();
    this.log(`Iniciado eBand Mobile. API Central: ${this.centralApiBase}`);

    if ('BarcodeDetector' in window) {
      try {
        this.barcodeDetector = new window.BarcodeDetector({ formats: ['qr_code'] });
      } catch (e) {
        this.barcodeDetector = null;
      }
    }
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

  get StatusBar() {
    return window.Capacitor?.Plugins?.StatusBar;
  }

  get NativeBiometric() {
    return window.Capacitor?.Plugins?.NativeBiometric;
  }

  async init() {
    // 1. Inicializar Tema y Lenguaje
    await this.initTheme();
    await this.initLanguage();

    this.initNetworkListener();
    this.initAppNavigationListener();

    // 2. Comprobar si ya existe una agrupación configurada previamente
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
  /*  IDIOMA (i18n)                                                             */
  /* -------------------------------------------------------------------------- */
  async initLanguage() {
    let savedLang = null;
    try {
      const { value } = await this.Preferences.get({ key: 'eband_lang' });
      savedLang = value;
    } catch (e) {
      // ignore
    }

    if (!savedLang) {
      const navLang = (navigator.language || navigator.userLanguage || 'es').toLowerCase();
      if (navLang.startsWith('ca') || navLang.startsWith('va')) {
        savedLang = 'va';
      } else if (navLang.startsWith('en')) {
        savedLang = 'en';
      } else {
        savedLang = 'es';
      }
    }

    this.setLanguage(savedLang, false);
  }

  async setLanguage(lang, persist = true) {
    if (!TRANSLATIONS[lang]) {
      lang = 'es';
    }
    this.currentLanguage = lang;

    // Actualizar botones de selector
    document.querySelectorAll('.lang-btn').forEach((btn) => {
      btn.classList.toggle('active', btn.getAttribute('data-lang') === lang);
    });

    // Actualizar textos en el DOM
    const dict = TRANSLATIONS[lang];
    document.querySelectorAll('[data-i18n]').forEach((el) => {
      const key = el.getAttribute('data-i18n');
      if (dict[key]) {
        if (dict[key].includes('<strong') || dict[key].includes('<span')) {
          el.innerHTML = dict[key];
        } else {
          el.textContent = dict[key];
        }
      }
    });

    // Actualizar placeholders
    document.querySelectorAll('[data-i18n-placeholder]').forEach((el) => {
      const key = el.getAttribute('data-i18n-placeholder');
      if (dict[key]) {
        el.placeholder = dict[key];
      }
    });

    if (persist) {
      try {
        await this.Preferences.set({ key: 'eband_lang', value: lang });
      } catch (e) {
        // ignore
      }
    }
  }

  t(key) {
    const dict = TRANSLATIONS[this.currentLanguage] || TRANSLATIONS.es;
    return dict[key] || key;
  }

  /* -------------------------------------------------------------------------- */
  /*  TEMA DÍA / NOCHE                                                          */
  /* -------------------------------------------------------------------------- */
  async initTheme() {
    let savedTheme = null;
    try {
      const { value } = await this.Preferences.get({ key: 'eband_theme' });
      savedTheme = value;
    } catch (e) {
      // ignore
    }

    if (savedTheme === 'dark' || savedTheme === 'light') {
      this.applyTheme(savedTheme);
    } else {
      const isDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
      this.applyTheme(isDark ? 'dark' : 'light', false);
    }

    if (window.matchMedia) {
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (this.currentTheme === 'auto') {
          this.applyTheme(e.matches ? 'dark' : 'light', false);
        }
      });
    }
  }

  async toggleTheme() {
    const activeTheme = document.documentElement.getAttribute('data-theme') || 
      (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    
    const nextTheme = activeTheme === 'dark' ? 'light' : 'dark';
    this.applyTheme(nextTheme, true);
  }

  async applyTheme(theme, persist = false) {
    this.currentTheme = theme;
    document.documentElement.setAttribute('data-theme', theme);

    if (this.StatusBar) {
      try {
        if (theme === 'dark') {
          await this.StatusBar.setStyle({ style: 'DARK' });
          await this.StatusBar.setBackgroundColor({ color: '#0f172a' });
        } else {
          await this.StatusBar.setStyle({ style: 'LIGHT' });
          await this.StatusBar.setBackgroundColor({ color: '#f8fafc' });
        }
      } catch (e) {
        // ignore on web
      }
    }

    if (persist) {
      try {
        await this.Preferences.set({ key: 'eband_theme', value: theme });
      } catch (e) {
        // ignore
      }
    }
  }

  /* -------------------------------------------------------------------------- */
  /*  ESCÁNER DE CÓDIGO QR                                                      */
  /* -------------------------------------------------------------------------- */
  extractBandCodeFromQr(scannedText) {
    if (!scannedText) return '';
    let text = scannedText.trim();

    // 1. Si es una URL completa (ej: https://bacm.eband.app o https://eband.app/join?code=BACM)
    try {
      if (text.startsWith('http://') || text.startsWith('https://')) {
        const url = new URL(text);
        if (url.searchParams.has('code')) {
          return url.searchParams.get('code').toUpperCase();
        }
        // Si el subdominio es el código (ej: bacm.eband.app)
        const parts = url.hostname.split('.');
        if (parts.length >= 3 && (parts[1] === 'eband' || parts[1] === 'localhost')) {
          const sub = parts[0];
          if (sub !== 'www' && sub !== 'api') {
            return sub.toUpperCase();
          }
        }
      }
    } catch (e) {
      // no es URL válida, usar fallback
    }

    // 2. Extraer caracteres alfanuméricos y guiones
    const cleaned = text.replace(/[^A-Za-z0-9_-]/g, '').toUpperCase();
    return cleaned;
  }

  async startQrScanner() {
    this.log('Iniciando escáner QR...');
    const modal = document.getElementById('qr-modal');
    const video = document.getElementById('qr-video');
    const errorBanner = document.getElementById('qr-error-msg');

    if (errorBanner) errorBanner.style.display = 'none';
    if (modal) modal.classList.add('is-open');

    try {
      this.qrStream = await navigator.mediaDevices.getUserMedia({
        video: {
          facingMode: { ideal: 'environment' },
          width: { ideal: 1280 },
          height: { ideal: 720 },
        },
      });

      if (video) {
        video.srcObject = this.qrStream;
        await video.play();
        this.qrScanActive = true;
        this.runQrScanLoop();
      }
    } catch (err) {
      this.log('Error accediendo a la cámara:', err?.message || err);
      if (errorBanner) {
        errorBanner.textContent = this.t('qr_camera_error');
        errorBanner.style.display = 'block';
      }
    }
  }

  async runQrScanLoop() {
    if (!this.qrScanActive) return;

    const video = document.getElementById('qr-video');
    const canvas = document.getElementById('qr-canvas');

    if (video && video.readyState === video.HAVE_ENOUGH_DATA) {
      // 1. Intentar con BarcodeDetector nativo (ultra-rápido en Chromium/Android)
      if (this.barcodeDetector) {
        try {
          const barcodes = await this.barcodeDetector.detect(video);
          if (barcodes && barcodes.length > 0 && barcodes[0].rawValue) {
            this.handleQrScanned(barcodes[0].rawValue);
            return;
          }
        } catch (e) {
          // fallback a jsQR
        }
      }

      // 2. Fallback a jsQR
      if (window.jsQR && canvas) {
        const ctx = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = window.jsQR(imageData.data, imageData.width, imageData.height, {
          inversionAttempts: 'dontInvert',
        });

        if (code && code.data) {
          this.handleQrScanned(code.data);
          return;
        }
      }
    }

    if (this.qrScanActive) {
      requestAnimationFrame(() => this.runQrScanLoop());
    }
  }

  handleQrScanned(rawData) {
    this.log(`QR detectado: ${rawData}`);
    if (navigator.vibrate) {
      try {
        navigator.vibrate(100);
      } catch (e) {}
    }

    const bandCode = this.extractBandCodeFromQr(rawData);
    this.stopQrScanner();

    if (bandCode) {
      const codeInput = document.getElementById('band-code');
      if (codeInput) {
        codeInput.value = bandCode;
      }
      this.handleValidateCode();
    } else {
      this.showError('El código QR escaneado no contiene un identificador válido.');
    }
  }

  stopQrScanner() {
    this.qrScanActive = false;
    if (this.qrStream) {
      this.qrStream.getTracks().forEach((track) => track.stop());
      this.qrStream = null;
    }
    const modal = document.getElementById('qr-modal');
    if (modal) {
      modal.classList.remove('is-open');
    }
  }

  async scanQrFromGallery() {
    this.log('Escaneando QR desde imagen de galería...');
    const photoUrl = await this.takePhoto();
    if (!photoUrl) return;

    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = () => {
      const canvas = document.getElementById('qr-canvas') || document.createElement('canvas');
      const ctx = canvas.getContext('2d');
      canvas.width = img.naturalWidth || img.width;
      canvas.height = img.naturalHeight || img.height;
      ctx.drawImage(img, 0, 0);

      const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
      if (window.jsQR) {
        const code = window.jsQR(imageData.data, imageData.width, imageData.height, {
          inversionAttempts: 'attemptBoth',
        });
        if (code && code.data) {
          this.handleQrScanned(code.data);
          return;
        }
      }

      const errorBanner = document.getElementById('qr-error-msg');
      if (errorBanner) {
        errorBanner.textContent = this.t('qr_not_found_in_image');
        errorBanner.style.display = 'block';
      }
    };
    img.onerror = () => {
      this.showError(this.t('qr_not_found_in_image'));
    };
    img.src = photoUrl;
  }

  /* -------------------------------------------------------------------------- */
  /*  MODAL DE AYUDA Y BANDA DEMO                                               */
  /* -------------------------------------------------------------------------- */
  openHelpModal() {
    const modal = document.getElementById('help-modal');
    if (modal) {
      modal.classList.add('is-open');
    }
  }

  closeHelpModal() {
    const modal = document.getElementById('help-modal');
    if (modal) {
      modal.classList.remove('is-open');
    }
  }

  loadDemoBand() {
    const codeInput = document.getElementById('band-code');
    if (codeInput) {
      codeInput.value = 'DEMO';
      this.handleValidateCode();
    }
  }

  /* -------------------------------------------------------------------------- */
  /*  NOTIFICACIONES PUSH (OneSignal)                                         */
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
  /*  NAVEGACIÓN NATIVA Y BOTÓN ATRÁS                                        */
  /* -------------------------------------------------------------------------- */
  initAppNavigationListener() {
    if (this.App) {
      this.App.addListener('backButton', ({ canGoBack }) => {
        // 1. Si el escáner QR está abierto, cerrarlo
        const qrModal = document.getElementById('qr-modal');
        if (qrModal && qrModal.classList.contains('is-open')) {
          this.stopQrScanner();
          return;
        }

        // 2. Si el modal de ayuda está abierto, cerrarlo
        const helpModal = document.getElementById('help-modal');
        if (helpModal && helpModal.classList.contains('is-open')) {
          this.closeHelpModal();
          return;
        }

        // 3. Si estamos en previsualización de banda, volver a introducir código
        if (this.currentResolvedTenant) {
          this.handleCancelPreview();
          return;
        }

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
  /*  CÁMARA Y ARCHIVOS NATIVOS                                              */
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
        source: 'PROMPT',
      });
      return image.webPath;
    } catch (e) {
      this.log('Aviso cancelado o error en cámara:', e?.message || e);
      return null;
    }
  }

  /* -------------------------------------------------------------------------- */
  /*  ACCESO BIOMÉTRICO (Huella / Face ID)                                   */
  /* -------------------------------------------------------------------------- */
  async checkAndPromptBiometrics() {
    if (!this.NativeBiometric) {
      return true;
    }

    try {
      const { value: biometricEnabled } = await this.Preferences.get({ key: 'eband_biometric_enabled' });
      if (biometricEnabled !== 'true') {
        return true;
      }

      const available = await this.NativeBiometric.isAvailable();
      if (!available?.isAvailable) {
        return true;
      }

      this.log('Solicitando verificación biométrica...');
      await this.NativeBiometric.verifyIdentity({
        reason: this.t('biometric_desc'),
        title: this.t('biometric_title'),
        subtitle: 'eBand',
        description: 'eBand Security',
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
      this.showError(this.t('error_empty_code'));
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
        throw new Error(`${this.t('error_invalid_response')} (HTTP ${response.status})`);
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
      this.showError(err.message || this.t('error_network'));
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
      this.showError(this.t('error_saving'));
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
