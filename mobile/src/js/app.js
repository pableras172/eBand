/**
 * eBand Mobile Controller
 * Soporte: Onboarding Asistente (4 Slides + Decisión + Rutas SÍ/NO),
 * Paleta Color Hunt (#3368a0, #66a3bf, #c8dfdb, #f2efe7),
 * Multidioma (ES/VAL/EN), Modo Día/Noche, Escáner QR, Demo Band,
 * Píldoras de Valor, OneSignal Push, Biometría, Cámara y Navegación
 */

// URL del dominio central de producción de eBand
const DEFAULT_CENTRAL_API = 'https://eband.app';

// Diccionario de Traducciones (Castellano, Valenciano, Inglés)
const TRANSLATIONS = {
  es: {
    subtitle: 'Tu agrupación musical siempre contigo',
    btn_next: 'Siguiente',
    btn_skip: 'Saltar presentación',
    btn_start: 'Comenzar',
    
    // Carrusel / Slides
    slide1_title: 'Tu banda, siempre conectada',
    slide1_desc: 'Toda la información y actividad de tu sociedad musical en tu móvil: moderna, accesible y siempre al día.',
    slide2_title: 'Actividades y Ensayos',
    slide2_desc: 'Consulta el calendario de ensayos, conciertos y actuaciones con horarios y localizaciones en tiempo real.',
    slide3_title: 'Control de Asistencia',
    slide3_desc: 'Confirma tu presencia con un solo toque y facilita la planificación musical a tus directores y directiva.',
    slide4_title: 'Avisos y Comunicación',
    slide4_desc: 'Recibe notificaciones inmediatas de cambios de última hora, convocatorias y notas oficiales de tu agrupación.',

    // Pregunta Asistente
    question_badge: 'Asistente de inicio',
    question_title: '¿Tu banda ya utiliza eBand?',
    question_desc: 'Selecciona la opción que mejor describa tu caso para guiarte:',
    option_yes_title: 'Sí, mi banda ya usa eBand',
    option_yes_desc: 'Tengo el código de mi agrupación o un código QR',
    option_no_title: 'No, aún no usamos eBand',
    option_no_desc: 'Quiero probar una demo o solicitar información',

    // Vista SÍ tiene banda
    has_band_title: 'Conectar con tu agrupación',
    has_band_subtitle: 'Introduce el código o escanea el QR de tu banda',
    code_label: 'Código de tu agrupación',
    code_placeholder: 'EJ: BANDA-VALENCIA',
    btn_continue: 'Continuar',
    btn_scan_qr: 'Escanear Código QR',
    btn_scan_gallery: 'Escanear desde foto o galería',
    help_link: '¿No sabes el código de tu agrupación?',

    // Vista NO tiene banda
    no_band_badge: 'Descubre eBand',
    no_band_title: 'Lleva tu banda al siguiente nivel',
    no_band_subtitle: 'La plataforma diseñada especialmente para bandas de música, sociedades musicales y agrupaciones.',
    btn_demo: 'Probar Banda Demo',
    btn_demo_sub: 'Explora una banda de ejemplo sin registrarte',
    no_band_cta_title: '¿Quieres eBand en tu agrupación?',
    no_band_cta_desc: 'Si eres director, directivo o músico y quieres implantar eBand en tu sociedad musical, solicita información sin compromiso.',
    btn_more_info: 'Solicitar información / Registrar banda',

    // Píldoras de valor
    pill_activities_title: 'Actividades',
    pill_activities_desc: 'Ensayos, conciertos y actuaciones',
    pill_attendance_title: 'Asistencias',
    pill_attendance_desc: 'Control y confirmación en tiempo real',
    pill_communication_title: 'Comunicación',
    pill_communication_desc: 'Avisos y notificaciones al móvil',

    // Modal de Ayuda
    help_modal_title: '¿Dónde encuentro mi código?',
    help_modal_p1: 'El código de agrupación es un identificador único asignado a cada sociedad musical o banda registrada en eBand.',
    help_modal_step1: '<strong>Consulta a tu directiva o secretaría:</strong> Ellos tienen el código oficial de acceso para los músicos.',
    help_modal_step2: '<strong>Revisa tu correo de bienvenida:</strong> Si recibiste una invitación de eBand, el código aparece indicado en el mensaje.',
    help_modal_step3: '<strong>¿Eres director o responsable?</strong> Si tu banda aún no está en eBand, puedes solicitar el alta y comenzar a probarla hoy mismo.',
    help_modal_close: 'Entendido',

    // Escáner QR
    qr_modal_title: 'Escanear Código QR',
    qr_modal_desc: 'Enfoca el código QR de tu banda',
    qr_camera_error: 'No se pudo iniciar la cámara. Comprueba los permisos en los ajustes del dispositivo.',
    qr_not_found_in_image: 'No se encontró ningún código QR en la imagen seleccionada.',

    // Previsualización y estados
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
    splash_connecting: 'Conectando con tu agrupación...',
    press_back_again_to_exit: 'Pulsa atrás otra vez para salir',
  },

  va: {
    subtitle: 'La teua agrupació musical sempre amb tu',
    btn_next: 'Següent',
    btn_skip: 'Saltar presentació',
    btn_start: 'Començar',

    // Carrusel / Slides
    slide1_title: 'La teua banda, sempre connectada',
    slide1_desc: 'Tota la informació i activitat de la teua societat musical al teu mòbil: moderna, accessible i sempre al dia.',
    slide2_title: 'Activitats i Assajos',
    slide2_desc: 'Consulta el calendari d\'assajos, concerts i actuacions amb horaris i localitzacions en temps real.',
    slide3_title: 'Control d\'Assistència',
    slide3_desc: 'Confirma la teua presència amb un sol toc i facilita la planificació musical als directors i directiva.',
    slide4_title: 'Avisos i Comunicació',
    slide4_desc: 'Reb notificacions immediates de canvis d\'última hora, convocatòries i notes oficials de la teua agrupació.',

    // Pregunta Asistente
    question_badge: 'Assistent d\'inici',
    question_title: 'La teua banda ja utilitza eBand?',
    question_desc: 'Selecciona l\'opció que millor descriga el teu cas per a guiar-te:',
    option_yes_title: 'Sí, la meua banda ja usa eBand',
    option_yes_desc: 'Tinc el codi de la meua agrupació o un codi QR',
    option_no_title: 'No, encara no usem eBand',
    option_no_desc: 'Vull provar una demo o demanar informació',

    // Vista SÍ tiene banda
    has_band_title: 'Connectar amb la teua agrupació',
    has_band_subtitle: 'Introduïx el codi o escana el QR de la teua banda',
    code_label: 'Codi de la teua agrupació',
    code_placeholder: 'EX: BANDA-VALENCIA',
    btn_continue: 'Continuar',
    btn_scan_qr: 'Escanar Codi QR',
    btn_scan_gallery: 'Escanar des de foto o galeria',
    help_link: 'No saps el codi de la teua agrupació?',

    // Vista NO tiene banda
    no_band_badge: 'Descobrix eBand',
    no_band_title: 'Porta la teua banda al següent nivell',
    no_band_subtitle: 'La plataforma dissenyada especialment per a bandes de música, societats musicals i agrupacions.',
    btn_demo: 'Provar Banda Demo',
    btn_demo_sub: 'Explora una agrupació d\'exemple sense registrar-te',
    no_band_cta_title: 'Vols eBand a la teua agrupació?',
    no_band_cta_desc: 'Si ets director, directiu o músic i vols implantar eBand a la teua societat musical, demana informació.',
    btn_more_info: 'Demanar informació / Registrar banda',

    // Píldoras de valor
    pill_activities_title: 'Activitats',
    pill_activities_desc: 'Assajos, concerts i actuacions',
    pill_attendance_title: 'Assistències',
    pill_attendance_desc: 'Confirmació i control en temps real',
    pill_communication_title: 'Comunicació',
    pill_communication_desc: 'Avisos i notificacions al mòbil',

    // Modal de Ayuda
    help_modal_title: 'On trobe el meu codi?',
    help_modal_p1: 'El codi d\'agrupació és un identificador únic assignat a cada societat musical o banda registrada en eBand.',
    help_modal_step1: '<strong>Consulta a la teua directiva o secretaria:</strong> Ells tenen el codi oficial d\'accés per als músics.',
    help_modal_step2: '<strong>Revisa el teu correu de benvinguda:</strong> Si vas rebre una invitació d\'eBand, el codi ve indicat en el missatge.',
    help_modal_step3: '<strong>Ets director o responsable?</strong> Si la teua banda encara no està en eBand, pots sol·licitar l\'alta i començar a provar-la.',
    help_modal_close: 'Entés',

    // Escáner QR
    qr_modal_title: 'Escanar Codi QR',
    qr_modal_desc: 'Enfoca el codi QR de la teua banda',
    qr_camera_error: 'No s\'ha pogut iniciar la càmera. Comprova els permisos als ajustos del dispositiu.',
    qr_not_found_in_image: 'No s\'ha trobat cap codi QR a la imatge seleccionada.',

    // Previsualización y estados
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
    splash_connecting: 'Connectant amb la teua agrupació...',
    press_back_again_to_exit: 'Prem arrere una altra vegada per a eixir',
  },

  en: {
    subtitle: 'Your musical ensemble always with you',
    btn_next: 'Next',
    btn_skip: 'Skip intro',
    btn_start: 'Get started',

    // Carrusel / Slides
    slide1_title: 'Your ensemble, always connected',
    slide1_desc: 'All your music society activity and info on your mobile: modern, accessible and always up to date.',
    slide2_title: 'Activities & Rehearsals',
    slide2_desc: 'View rehearsals, concerts and events schedules with real-time locations and announcements.',
    slide3_title: 'Attendance Tracking',
    slide3_desc: 'Confirm your attendance with a single tap and assist your musical directors in rehearsals planning.',
    slide4_title: 'Instant Announcements',
    slide4_desc: 'Receive immediate push notifications about last-minute changes, official calls and band notes.',

    // Pregunta Asistente
    question_badge: 'Getting started',
    question_title: 'Does your band use eBand?',
    question_desc: 'Select the option that best describes your situation:',
    option_yes_title: 'Yes, my band uses eBand',
    option_yes_desc: 'I have my ensemble code or a QR code',
    option_no_title: 'No, we don\'t use eBand yet',
    option_no_desc: 'I want to try a demo or request information',

    // Vista SÍ tiene banda
    has_band_title: 'Connect with your ensemble',
    has_band_subtitle: 'Enter your code or scan your band\'s QR code',
    code_label: 'Your ensemble code',
    code_placeholder: 'E.G. BAND-NAME',
    btn_continue: 'Continue',
    btn_scan_qr: 'Scan QR Code',
    btn_scan_gallery: 'Scan from photo or gallery',
    help_link: 'Don\'t know your ensemble code?',

    // Vista NO tiene banda
    no_band_badge: 'Discover eBand',
    no_band_title: 'Take your band to the next level',
    no_band_subtitle: 'The all-in-one management platform designed for bands and musical societies.',
    btn_demo: 'Try Demo Band',
    btn_demo_sub: 'Explore a demo band without registering',
    no_band_cta_title: 'Want eBand in your ensemble?',
    no_band_cta_desc: 'If you are a director, board member or musician and want eBand in your society, request info.',
    btn_more_info: 'Request info / Register band',

    // Píldoras de valor
    pill_activities_title: 'Activities',
    pill_activities_desc: 'Rehearsals, concerts and events',
    pill_attendance_title: 'Attendance',
    pill_attendance_desc: 'Real-time tracking and confirmation',
    pill_communication_title: 'Communication',
    pill_communication_desc: 'Instant announcements and push alerts',

    // Modal de Ayuda
    help_modal_title: 'Where do I find my code?',
    help_modal_p1: 'The ensemble code is a unique identifier assigned to each music society or band registered on eBand.',
    help_modal_step1: '<strong>Ask your board of directors or secretary:</strong> They have the official access code for musicians.',
    help_modal_step2: '<strong>Check your welcome email:</strong> If you received an invitation from eBand, the code is specified in the message.',
    help_modal_step3: '<strong>Are you a director or manager?</strong> If your band is not yet on eBand, you can request registration and try it out today.',
    help_modal_close: 'Got it',

    // Escáner QR
    qr_modal_title: 'Scan QR Code',
    qr_modal_desc: 'Point your camera at your band\'s QR code',
    qr_camera_error: 'Could not access the camera. Please check app permissions in system settings.',
    qr_not_found_in_image: 'No QR code was found in the selected image.',

    // Previsualización y estados
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
    splash_connecting: 'Connecting to your ensemble...',
    press_back_again_to_exit: 'Press back again to exit',
  }
};

class EBandMobileApp {
  constructor() {
    this.currentResolvedTenant = null;
    this.pendingDestinationUrl = null;
    this.currentLanguage = 'es';
    this.currentTheme = 'auto'; // 'auto' | 'light' | 'dark'
    this.currentView = 'intro-slides'; // 'intro-slides' | 'question' | 'has-band' | 'no-band'
    this.currentSlide = 1;
    this.totalSlides = 4;
    this.lastBackPressTime = 0;
    this.toastTimeout = null;
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

  get SplashScreen() {
    return window.Capacitor?.Plugins?.SplashScreen;
  }

  get NativeBiometric() {
    return window.Capacitor?.Plugins?.NativeBiometric;
  }

  hideNativeSplashScreen() {
    if (this.SplashScreen) {
      try {
        this.SplashScreen.hide({ fadeOutDuration: 250 });
      } catch (e) {
        // ignore
      }
    }
  }

  dismissSplash() {
    const splash = document.getElementById('app-splash');
    if (splash) {
      splash.classList.add('fade-out');
      setTimeout(() => {
        splash.style.display = 'none';
      }, 450);
    }
  }

  async init() {
    const initStartTime = Date.now();
    this.hideNativeSplashScreen();

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

        const splashStatus = document.getElementById('splash-status');
        if (splashStatus) {
          splashStatus.textContent = this.t('splash_connecting');
        }

        // Comprobar si la biometría está activada o disponible
        const biometricAuthPassed = await this.checkAndPromptBiometrics();
        if (biometricAuthPassed) {
          this.log(`Redirigiendo a: ${tenantUrl}`);
          window.location.replace(tenantUrl);
          return;
        } else {
          this.dismissSplash();
          this.showBiometricScreen();
          return;
        }
      }
      this.log('No hay agrupación guardada. Iniciando asistente de bienvenida.');
    } catch (err) {
      this.log('Aviso al leer configuración previa', err?.message || err);
    }

    // Inicializar carrusel en slide 1
    this.goToSlide(1);
    this.goToView('intro-slides', false);

    // Asegurar que el splash animado del metrónomo se aprecie con fluidez
    const elapsed = Date.now() - initStartTime;
    const remaining = Math.max(0, 1100 - elapsed);

    setTimeout(() => {
      this.dismissSplash();
    }, remaining);
  }

  /* -------------------------------------------------------------------------- */
  /*  CONTROL DE VISTAS Y ASISTENTE / ONBOARDING                                */
  /* -------------------------------------------------------------------------- */
  goToView(viewId, updateNav = true) {
    this.currentView = viewId;
    document.querySelectorAll('.view-section').forEach((sec) => {
      sec.classList.remove('active');
    });

    const target = document.getElementById(`view-${viewId}`);
    if (target) {
      target.classList.add('active');
    }

    // Botón Atrás en la barra superior
    const backBtn = document.getElementById('nav-back-btn');
    if (backBtn) {
      if (viewId === 'intro-slides' && this.currentSlide === 1) {
        backBtn.style.display = 'none';
      } else {
        backBtn.style.display = 'inline-flex';
      }
    }

    if (viewId === 'has-band') {
      const codeInput = document.getElementById('band-code');
      if (codeInput) {
        setTimeout(() => codeInput.focus(), 200);
      }
    }
  }

  goToSlide(slideNumber) {
    this.currentSlide = slideNumber;
    document.querySelectorAll('.carousel-slide').forEach((slide) => {
      slide.classList.toggle('active', parseInt(slide.getAttribute('data-slide'), 10) === slideNumber);
    });

    document.querySelectorAll('.carousel-dots .dot').forEach((dot) => {
      dot.classList.toggle('active', parseInt(dot.getAttribute('data-dot'), 10) === slideNumber);
    });

    // Actualizar texto del botón en la última diapositiva
    const nextBtnText = document.getElementById('btn-slide-next-text');
    if (nextBtnText) {
      if (slideNumber === this.totalSlides) {
        nextBtnText.textContent = this.t('btn_start');
      } else {
        nextBtnText.textContent = this.t('btn_next');
      }
    }

    // Botón Atrás
    const backBtn = document.getElementById('nav-back-btn');
    if (backBtn && this.currentView === 'intro-slides') {
      backBtn.style.display = slideNumber > 1 ? 'inline-flex' : 'none';
    }
  }

  nextSlide() {
    if (this.currentSlide < this.totalSlides) {
      this.goToSlide(this.currentSlide + 1);
    } else {
      // Fin del carrusel: pasar a la pantalla de decisión
      this.goToView('question');
    }
  }

  skipIntroSlides() {
    this.goToView('question');
  }

  handleBackNavigation() {
    if (this.currentResolvedTenant) {
      this.handleCancelPreview();
      return;
    }

    if (this.currentView === 'has-band' || this.currentView === 'no-band') {
      this.goToView('question');
      return;
    }

    if (this.currentView === 'question') {
      this.goToSlide(this.totalSlides);
      this.goToView('intro-slides');
      return;
    }

    if (this.currentView === 'intro-slides' && this.currentSlide > 1) {
      this.goToSlide(this.currentSlide - 1);
      return;
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

    // Actualizar botón de slide actual
    const nextBtnText = document.getElementById('btn-slide-next-text');
    if (nextBtnText) {
      nextBtnText.textContent = this.currentSlide === this.totalSlides ? this.t('btn_start') : this.t('btn_next');
    }

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
          await this.StatusBar.setBackgroundColor({ color: '#0d1726' });
        } else {
          await this.StatusBar.setStyle({ style: 'LIGHT' });
          await this.StatusBar.setBackgroundColor({ color: '#f2efe7' });
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

    try {
      if (text.startsWith('http://') || text.startsWith('https://')) {
        const url = new URL(text);
        if (url.searchParams.has('code')) {
          return url.searchParams.get('code').toUpperCase();
        }
        const parts = url.hostname.split('.');
        if (parts.length >= 3 && (parts[1] === 'eband' || parts[1] === 'localhost')) {
          const sub = parts[0];
          if (sub !== 'www' && sub !== 'api') {
            return sub.toUpperCase();
          }
        }
      }
    } catch (e) {
      // ignore
    }

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
      if (this.barcodeDetector) {
        try {
          const barcodes = await this.barcodeDetector.detect(video);
          if (barcodes && barcodes.length > 0 && barcodes[0].rawValue) {
            this.handleQrScanned(barcodes[0].rawValue);
            return;
          }
        } catch (e) {
          // fallback
        }
      }

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
    // Si estamos en otra vista, asegurar que abrimos has-band
    this.goToView('has-band');
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

  showToast(message) {
    const toast = document.getElementById('toast-message');
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('show');
    clearTimeout(this.toastTimeout);
    this.toastTimeout = setTimeout(() => {
      toast.classList.remove('show');
    }, 2000);
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

        // 4. Retroceder en el asistente si no estamos en la primera slide
        if (this.currentView !== 'intro-slides' || this.currentSlide > 1) {
          this.handleBackNavigation();
          return;
        }

        // 5. Si hay historial en el navegador y canGoBack es verdadero, retroceder
        if (canGoBack || window.history.length > 2) {
          window.history.back();
          return;
        }

        // 6. Doble pulsación/gesto Atrás para salir de la aplicación
        const now = Date.now();
        if (this.lastBackPressTime && (now - this.lastBackPressTime < 2000)) {
          this.App.exitApp();
        } else {
          this.lastBackPressTime = now;
          this.showToast(this.t('press_back_again_to_exit'));
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
      let json = null;

      try {
        json = JSON.parse(rawText);
      } catch (parseError) {
        console.error('[EBAND_DEBUG] ERROR PARSEANDO JSON:', parseError);
        throw new Error(`${this.t('error_invalid_response')} (HTTP ${response.status})`);
      }

      console.log('[EBAND_DEBUG] <<< JSON PARSEADO EXITOSAMENTE:', json);

      if (!response.ok || !json.success) {
        throw new Error(json.message || `No se encontró la agrupación (HTTP ${response.status})`);
      }

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

    if (tenant.logo_url) {
      previewLogo.src = tenant.logo_url;
      previewLogo.style.display = 'block';
    } else {
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
