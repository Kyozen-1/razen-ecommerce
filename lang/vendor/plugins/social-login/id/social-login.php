<?php

return [
    'menu' => 'Masuk Sosial',
    'settings' => [
        'description' => 'Konfigurasikan opsi login sosial',
        'enable' => 'Aktifkan?',
        'facebook' => [
            'app_id' => 'ID Aplikasi',
            'app_secret' => 'Secret Aplikasi',
            'description' => 'Aktifkan/nonaktifkan & konfigurasikan kredensial aplikasi untuk login Facebook',
            'helper' => 'Silakan buka https://developers.facebook.com untuk membuat pembaruan aplikasi ID Aplikasi baru, Rahasia Aplikasi. URL panggilan balik adalah :callback',
            'title' => 'Pengaturan masuk Facebook',
        ],
        'github' => [
            'app_id' => 'ID Aplikasi',
            'app_secret' => 'Secret Aplikasi',
            'description' => 'Aktifkan/nonaktifkan & konfigurasikan kredensial aplikasi untuk login Github',
            'helper' => 'Silakan buka https://github.com/settings/developers untuk membuat ID Aplikasi pembaruan aplikasi baru, Rahasia Aplikasi. URL panggilan balik adalah :callback',
            'title' => 'Pengaturan masuk Github',
        ],
        'google' => [
            'app_id' => 'ID Aplikasi',
            'app_secret' => 'Secret Aplikasi',
            'description' => 'Aktifkan/nonaktifkan & konfigurasikan kredensial aplikasi untuk login Google',
            'helper' => 'Buka https://console.developers.google.com/apis/dashboard untuk membuat pembaruan aplikasi ID Aplikasi baru, Rahasia Aplikasi. URL panggilan balik adalah :callback',
            'title' => 'Pengaturan masuk Google',
        ],
        'linkedin' => [
            'app_id' => 'ID Aplikasi',
            'app_secret' => 'Secret Aplikasi',
            'description' => 'Aktifkan/nonaktifkan & konfigurasikan kredensial aplikasi untuk login Linkedin',
            'helper' => 'Silakan buka https://www.linkedin.com/developers/apps/new untuk membuat ID Aplikasi pembaruan aplikasi baru, Rahasia Aplikasi. URL panggilan balik adalah :callback',
            'title' => 'Pengaturan masuk Linkedin',
        ],
        'title' => 'Pengaturan Login Sosial',
    ],
];
