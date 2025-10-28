<?php

function wbsContentConfigurationMenu()
{
    add_menu_page(
        'پیکربندی محتوا',
        'پیکربندی محتوا',
        'manage_options',
        'contentConfiguration',
        'wbsContentConfiguration',
        get_template_directory_uri() . '/images/temp/sibaneh-logo.png',
        2
    );
    add_submenu_page(
        'contentConfiguration',
        'دنیای اپلیکیشن و بازی‌ها',
        'دنیای اپلیکیشن و بازی‌ها',
        'manage_options',
        'huboftheworldofapplicationsandgames',
        function() {
            $_GET['category'] = 'apps_games'; 
            wbsSibanehTableOfContents();
        }
    );
    add_submenu_page(
        'contentConfiguration',
        'آموزش‌های جامع اپل',
        'آموزش‌های جامع اپل',
        'manage_options',
        'comprehensiveappletutorials', 
        function() {
            $_GET['category'] = 'apple_tutorials';
            wbsSibanehTableOfContents();
        }
    );
    add_submenu_page(
        'contentConfiguration',
        'اخبار و تحلیل‌ها',
        'اخبار و تحلیل‌ها',
        'manage_options',
        'newsandanalysis', 
        function() {
            $_GET['category'] = 'news_analysis';
            wbsSibanehTableOfContents();
        }
    );
}

add_action('admin_menu', 'wbsContentConfigurationMenu');

function wbsRemoveDuplicateContentConfigurationSubmenu() {
    remove_submenu_page( 'contentConfiguration', 'contentConfiguration' );
}
add_action('admin_menu', 'wbsRemoveDuplicateContentConfigurationSubmenu', 999);


function wbsSibanehTableOfContents()
{
    require_once THEME_LIB_DIR . 'tableOfContents/template/tableOfContents-admin.php';
}

add_action('admin_head', function () {
    ?>
    <style>
        /* Force Sibaneh menu icon to be centered and grayscale */
        #toplevel_page_contentConfiguration .wp-menu-image img {
            width: 20px !important;
            height: 20px !important;
            display: block;          /* make it a block element */
            margin: 0 auto;          /* center horizontally */
            object-fit: contain;     /* keep proportions */
            filter: grayscale(100%); /* always black & white */
        }
    </style>
    <?php
});