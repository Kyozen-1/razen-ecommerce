<?php

return [
    'name' => 'Buletin',
    'settings' => [
        'description' => 'Pengaturan untuk buletin',
        'email' => [
            'templates' => [
                'description' => 'Konfigurasikan templat email buletin',
                'title' => 'Buletin',
                'to_admin' => [
                    'description' => 'Template untuk mengirim email ke admin',
                    'title' => 'Kirim email ke admin',
                ],
                'to_user' => [
                    'description' => 'Template untuk mengirim email ke pelanggan',
                    'title' => 'Kirim email ke pengguna',
                ],
            ],
        ],
        'mailchimp_api_key' => 'API Key Mailchimp',
        'mailchimp_list' => 'Daftar Mailchimp',
        'mailchimp_list_id' => 'ID Daftar Mailchimp',
        'sendgrid_api_key' => 'API Key Sendgrid',
        'sendgrid_list' => 'Daftar Sendgrid',
        'sendgrid_list_id' => 'ID Daftar Sendgrid',
        'title' => 'Buletin',
    ],
    'statuses' => [
        'subscribed' => 'Berlangganan',
        'unsubscribed' => 'Tidak berlangganan',
    ],
];
