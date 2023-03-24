<?php

return [
    'collapse_white_space' => 'Ciutkan ruang putih',
    'collapse_white_space_description' => 'Filter ini mengurangi byte yang dikirimkan dalam file HTML dengan menghapus spasi yang tidak perlu.',
    'defer_javascript' => 'Tunda javascript',
    'defer_javascript_description' => 'Menunda eksekusi javascript di HTML. Jika perlu batalkan penangguhan di beberapa skrip, gunakan data-pagespeed-no-defer sebagai atribut skrip untuk membatalkan penangguhan.',
    'elide_attributes' => 'Elide atribut',
    'elide_attributes_description' => 'Filter ini mengurangi ukuran transfer file HTML dengan menghapus atribut dari tag ketika nilai yang ditentukan sama dengan nilai default untuk atribut tersebut. Ini dapat menghemat sejumlah byte, dan dapat membuat dokumen lebih dapat dimampatkan dengan mengkanoniskan tag yang terpengaruh.',
    'inline_css' => 'CSS sebaris',
    'inline_css_description' => 'Filter ini mengubah atribut tag "gaya" sebaris menjadi kelas dengan memindahkan CSS ke header.',
    'insert_dns_prefetch' => 'Sisipkan prefetch DNS',
    'insert_dns_prefetch_description' => 'Filter ini menyuntikkan tag di HEAD untuk memungkinkan browser melakukan prefetching DNS.',
    'remove_comments' => 'Hapus komentar',
    'remove_comments_description' => 'Filter ini menghilangkan komentar HTML, JS, dan CSS. Filter mengurangi ukuran transfer file HTML dengan menghapus komentar. Bergantung pada file HTML, filter ini dapat secara signifikan mengurangi jumlah byte yang dikirimkan di jaringan.',
    'remove_quotes' => 'Hapus tanda kutip',
    'remove_quotes_description' => 'Filter ini menghilangkan tanda kutip yang tidak perlu dari atribut HTML. Meskipun diperlukan oleh berbagai spesifikasi HTML, browser mengizinkan penghilangannya ketika nilai atribut terdiri dari subset karakter tertentu (alfanumerik dan beberapa karakter tanda baca).',
    'settings' => [
        'description' => 'Perkecil keluaran HTML, sebariskan CSS, hapus komentar...',
        'enable' => 'Aktifkan optimalkan kecepatan halaman?',
        'title' => 'Optimalkan kecepatan halaman',
    ],
    'trim_urls' => 'Pangkas URL',
    'trim_urls_description' => 'Filter ini memangkas URL dengan menyelesaikannya dengan membuatnya relatif terhadap URL dasar untuk laman tersebut.',
];
