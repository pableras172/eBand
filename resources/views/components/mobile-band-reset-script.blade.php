@once
    <script>
        (function () {
            function revealMobileBandSwitchers() {
                if (!window.Capacitor?.isNativePlatform?.()) {
                    return;
                }

                document.querySelectorAll('[data-mobile-switch-band]').forEach(function (el) {
                    el.classList.remove('hidden');
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', revealMobileBandSwitchers);
            } else {
                revealMobileBandSwitchers();
            }

            document.addEventListener('livewire:navigated', revealMobileBandSwitchers);

            window.ebandReturnToBandSelector = async function (logoutUrl = null) {
                try {
                    if (logoutUrl) {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        await fetch(logoutUrl, {
                            method: 'POST',
                            headers: {
                                ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                                'Accept': 'application/json',
                            },
                            credentials: 'same-origin',
                        }).catch(function () {});
                    }

                    const prefs = window.Capacitor?.Plugins?.Preferences;
                    let homeUrl = null;

                    if (prefs) {
                        const res = await prefs.get({ key: 'eband_app_home_url' });
                        homeUrl = res?.value || null;

                        await Promise.all([
                            prefs.remove({ key: 'eband_tenant_code' }),
                            prefs.remove({ key: 'eband_tenant_url' }),
                            prefs.remove({ key: 'eband_tenant_name' }),
                            prefs.remove({ key: 'eband_tenant_id' }),
                            prefs.remove({ key: 'eband_logo_url' }),
                            prefs.remove({ key: 'eband_onesignal_app_id' }),
                        ]);
                    }

                    if (!homeUrl) {
                        const platform = window.Capacitor?.getPlatform?.();
                        homeUrl = platform === 'android'
                            ? 'https://localhost/index.html'
                            : 'capacitor://localhost/index.html';
                    }

                    const separator = homeUrl.includes('?') ? '&' : '?';
                    window.location.replace(homeUrl + separator + 'reset_band=1');
                } catch (e) {
                    const platform = window.Capacitor?.getPlatform?.();
                    const fallback = platform === 'android'
                        ? 'https://localhost/index.html?reset_band=1'
                        : 'capacitor://localhost/index.html?reset_band=1';
                    window.location.replace(fallback);
                }
            };
        })();
    </script>
@endonce
