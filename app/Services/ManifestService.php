<?php

namespace App\Services;

class ManifestService
{
    public function generate()
    {
        $baseUrl = url('/');

        $manifest = [
            'name' => 'eBand - Gestiona la banda',
            'short_name' => 'eBand',
            'description' => 'Facilita la Gestió de Bandes amb eBand',
            'start_url' => '/',
            'display' => 'standalone',
            'background_color' => '#ffffff',
            'theme_color' => '#034460',
            'orientation' => 'portrait',
            'scope' => '/',
            'screenshots' => [
                [
                    'src' => url('/imagenes/screenshots/captura1.png'),
                    'sizes' => '1920x1080',
                    'type' => 'image/png',
                    'form_factor' => 'wide',
                    'label' => 'Vista escritorio de eBand'
                ],
                [
                    'src' => url('/imagenes/screenshots/captura2.png'),
                    'sizes' => '1080x1920',
                    'type' => 'image/png',
                    'form_factor' => 'narrow',
                    'label' => 'Vista móvil de eBand'
                ]
            ],
            'icons' => [
                [
                    'src' => url('/imagenes/icons/favicons/logoSmall_192.png'),
                    'sizes' => '192x192',
                    'type' => 'image/png',
                ],
                [
                    'src' => url('/imagenes/icons/favicons/logoSmall_96.png'),
                    'sizes' => '96x96',
                    'type' => 'image/png',
                ],
                [
                    'src' => url('/imagenes/icons/favicons/logoSmall_48.png'),
                    'sizes' => '48x48',
                    'type' => 'image/png',
                ],
                [
                    'src' => url('/imagenes/icons/android/android-launchericon-36-36.png'),
                    'sizes' => '36x36',
                    'type' => 'image/png',
                    'density' => '0.75'
                ],
                [
                    'src' => url('/imagenes/icons/android/android-launchericon-48-48.png'),
                    'sizes' => '48x48',
                    'type' => 'image/png',
                    'density' => '1.0'
                ],
                [
                    'src' => url('/imagenes/icons/android/android-launchericon-72-72.png'),
                    'sizes' => '72x72',
                    'type' => 'image/png',
                    'density' => '1.5'
                ],
                [
                    'src' => url('/imagenes/icons/android/android-launchericon-96-96.png'),
                    'sizes' => '96x96',
                    'type' => 'image/png',
                    'density' => '2.0'
                ],
                [
                    'src' => url('/imagenes/icons/android/android-launchericon-144-144.png'),
                    'sizes' => '144x144',
                    'type' => 'image/png',
                    'density' => '3.0'
                ],
                [
                    'src' => url('/imagenes/icons/android/android-launchericon-192-192.png'),
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'density' => '4.0'
                ]
            ],
            'shortcuts' => [
                [
                    'name' => 'Calendari',
                    'short_name' => 'Calendari',
                    'description' => 'Accedeix als events de la banda',
                    'url' => '/actuacion',
                    'icons' => [
                        [
                            'src' => url('/imagenes/icons/eventos-icon.png'),
                            'sizes' => '96x96',
                            'type' => 'image/png'
                        ]
                    ]
                ],
                [
                    'name' => 'Perfil',
                    'short_name' => 'Perfil',
                    'description' => 'Accedeix al teu perfil',
                    'url' => '/user/profile',
                    'icons' => [
                        [
                            'src' => url('/imagenes/icons/perfil-icon.png'),
                            'sizes' => '96x96',
                            'type' => 'image/png'
                        ]
                    ]
                ]
            ],
            'related_applications' => [
                [
                    'platform' => 'webapp',
                    'url' => $baseUrl . '/manifest.json'
                ]
            ],
            'prefer_related_applications' => false
        ];

        return json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
