<?php

return [
    'enabled' => (bool) env('DEMO_MODE_ENABLED', true),
    'user_email' => env('DEMO_USER_EMAIL', 'demo@eband.app'),
    'read_only' => (bool) env('DEMO_READ_ONLY', false),
    'read_only_allowed_routes' => [
        // Add route names here if some write actions should be allowed in demo mode.
        'logout',
    ],
];
