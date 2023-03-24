<?php

return [
    'cache_commands' => 'Hapus perintah cache',
    'cache_management' => 'Manajemen cache',
    'commands' => [
        'clear_cms_cache' => [
            'description' => 'Hapus caching CMS: caching basis data, blok statis... Jalankan perintah ini saat Anda tidak melihat perubahan setelah memperbarui data.',
            'success_msg' => 'Cache dibersihkan',
            'title' => 'Hapus semua cache CMS',
        ],
        'clear_config_cache' => [
            'description' => 'Anda mungkin perlu menyegarkan cache konfigurasi saat Anda mengubah sesuatu di lingkungan produksi.',
            'success_msg' => 'Cache konfigurasi dibersihkan',
            'title' => 'Hapus cache konfigurasi',
        ],
        'clear_log' => [
            'description' => 'Hapus file log sistem',
            'success_msg' => 'Log sistem telah dibersihkan',
            'title' => 'Hapus catatan',
        ],
        'clear_route_cache' => [
            'description' => 'Hapus perutean cache.',
            'success_msg' => 'Cache rute telah dibersihkan',
            'title' => 'Hapus cache rute',
        ],
        'refresh_compiled_views' => [
            'description' => 'Hapus tampilan terkompilasi untuk memperbarui tampilan.',
            'success_msg' => 'Tampilan cache disegarkan',
            'title' => 'Segarkan tampilan yang dikompilasi',
        ],
    ],
];
