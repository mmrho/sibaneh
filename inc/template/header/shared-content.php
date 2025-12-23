<?php
// Shared site information
$site_data = [
    'name' => get_bloginfo('name') ?: 'سیبانه',
    'url' => esc_url(home_url('/')),
    'logo' => get_template_directory_uri() . '/images/temp/sibaneh-logo.png',
    'phone' => '۰۹۹۹۹۸۸۶۲۰۲',
    'search_placeholder' => 'جستجو...'
];

// Main menus
$main_menu = [
    [
        'title' => 'فروشگاه',
        'url' => '#',
        'has_submenu' => false
    ],
    [
        'title' => 'اپ‌استور',
        'url' => '#',
        'has_submenu' => true,
        'submenu' => [
            ['title' => 'آیتم زیرمنو 1', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 3', 'url' => '#']
        ]
    ],
    [
        'title' => 'مک‌استور',
        'url' => '#',
        'has_submenu' => true,
        'submenu' => [
            ['title' => 'آیتم زیرمنو 1', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 3', 'url' => '#']
        ]
    ],
    [
        'title' => 'سیبانه کد',
        'url' => '#',
        'has_submenu' => true,
        'submenu' => [
            ['title' => 'آیتم زیرمنو 1', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 3', 'url' => '#']
        ]
    ],
    [
        'title' => 'سیبانه فیکس',
        'url' => '#',
        'has_submenu' => true,
        'submenu' => [
            ['title' => 'آیتم زیرمنو 1', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 3', 'url' => '#']
        ]
    ],
    [
        'title' => 'سیبانه بیزینس',
        'url' => '#',
        'has_submenu' => true,
        'submenu' => [
            ['title' => 'آیتم زیرمنو 1', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 3', 'url' => '#']
        ]
    ],
    [
        'title' => 'سیبانه پرایم',
        'url' => '#',
        'has_submenu' => true,
        'submenu' => [
            ['title' => 'آیتم زیرمنو 1', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 3', 'url' => '#']
        ]
    ],
    [
        'title' => 'آکادمی سیبانه',
        'url' => '#',
        'has_submenu' => true,
        'submenu' => [
            ['title' => 'آیتم زیرمنو 1', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 3', 'url' => '#']
        ]
    ],
    [
        'title' => 'پشتیبانی',
        'url' => '#',
        'has_submenu' => false
    ],
    [
        'title' => 'چرا سیبانه؟',
        'url' => '#',
        'has_submenu' => false
    ]
];

// Support information
$support_info = [
    
    'search_icon' => 'icon-search-sbh',
    'shoping_bag_icon' => 'icon-shopping-bag-sbh'
];
?>