<?php

namespace App\Services;

class ManifestService
{
    public function generate()
    {
        $manifest = [
            'name' => 'eBand - Gestiona la banda',
            'short_name' => 'eBand',
            'description'=> 'Facilita la Gestió de Bandes amb eBand',
            'start_url' => '/',
            'display' => 'standalone',
            'background_color' => '#ffffff',
            'theme_color' => '#ffffff',
            'scope' => '/',
            'screenshots'=> [
                [
                 'src'=> '/storage/imagenes/captura2.png',
                  'sizes'=> '575x346',
                  'type'=> 'image/png',
                  'form_factor'=> 'wide',
                  'label'=> 'eBand'
                ],
                [
                    'src'=> '/storage/imagenes/captura2.png',
                     'sizes'=> '575x346',
                     'type'=> 'image/png',
                     'form_factor'=> 'narrow',
                     'label'=> 'eBand'
                   ]
            ],
            'icons' => [
                [
                    'src' => '/storage/imagenes/logoSmall_192.png',
                    'sizes' => '192x96',
                    'type' => 'image/png',
                ],
                [
                    'src' => '/storage/imagenes/logoSmall_96.png',
                    'sizes' => '96x48',
                    'type' => 'image/png',
                ],                
                [
                    'src' => '/storage/imagenes/logoSmall_48.png',
                    'sizes' => '48x24',
                    'type' => 'image/png',
                ],
                [
                    'src'=>'/storage/imagenes/android-icon-36x36.png',
                    'sizes'=>'36x36',
                    'type'=>'image/png',
                    'density'=>'0.75'
                ],
                [
                    'src'=>'/storage/imagenes/android-icon-48x48.png',
                    'sizes'=>'48x48',
                    'type'=>'image/png',
                    'density'=>'1.0'
                ],
                [
                    'src'=>'/storage/imagenes/android-icon-72x72.png',
                    'sizes'=>'72x72',
                    'type'=>'image/png',
                    'density'=>'1.5'
                ],
                [
                    'src'=>'/storage/imagenes/android-icon-96x96.png',
                    'sizes'=>'96x96',
                    'type'=>'image/png',
                    'density'=>'2.0'
                ],
                [
                    'src'=>'/storage/imagenes/android-icon-144x144.png',
                    'sizes'=>'144x144',
                    'type'=>'image/png',
                    'density'=>'3.0'
                ],
                [
                    'src'=>'/storage/imagenes/android-icon-192x192.png',
                    'sizes'=>'192x192',
                    'type'=>'image/png',
                    'density'=>'4.0'
                ]
            ],
        ];

        return json_encode($manifest);
    }
}
