<?php

namespace App\Services;

class ManifestService
{
    public function generate()
    {
        $manifest = [
            'name' => 'eBand - Gestiona la banda',
            'short_name' => 'eBand',
            'description'=> 'Gestió de Bandes',
            'start_url' => '/',
            'display' => 'standalone',
            'background_color' => '#ffffff',
            'theme_color' => '#ffffff',
            'scope' => '/',
            'icons' => [
                [
                    'src' => '/storage/imagenes/logoSmall_192.png',
                    'sizes' => '192x192',
                    'type' => 'image/png',
                ],
                [
                    'src' => '/storage/imagenes/logoSmall_96.png',
                    'sizes' => '96x96',
                    'type' => 'image/png',
                ],                
                [
                    'src' => '/storage/imagenes/logoSmall_192.png',
                    'sizes' => '192x192',
                    'type' => 'image/png',
                ],
            ],
        ];

        return json_encode($manifest);
    }
}
