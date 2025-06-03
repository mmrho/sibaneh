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
        'title' => 'خانه',
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
        'title' => 'توسعه‌دهندگان',
        'url' => '#',
        'has_submenu' => true,
        'submenu' => [
            ['title' => 'آیتم زیرمنو 1', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 3', 'url' => '#']
        ]
    ],
    [
        'title' => 'آموزش',
        'url' => '#',
        'has_submenu' => true,
        'submenu' => [
            ['title' => 'آیتم زیرمنو 1', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 3', 'url' => '#']
        ]
    ],
    [
        'title' => 'بلاگ',
        'url' => '#',
        'has_submenu' => true,
        'submenu' => [
            ['title' => 'آیتم زیرمنو 1', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 2', 'url' => '#'],
            ['title' => 'آیتم زیرمنو 3', 'url' => '#']
        ]
    ],
    [
        'title' => 'چرا سیبانه؟',
        'url' => '#',
        'has_submenu' => false
    ]
];

// Function buttons
$action_buttons = [
    'service' => [
        'text' => 'سرویس‌های سیبانه',
        'class' => 'service-button'
    ],
    'login' => [
        'text' => 'ورود',
        'class' => 'login-button'
    ]
];

// Support information
$support_info = [
    'phone_label' => 'واحد فروش',
    'phone_number' => $site_data['phone'],
    'support_text' => 'پشتیبانی',
    'support_icon' => 'icon-Online-Support'
];
?>