<?php

function wbsSibanehAcademyMenu()
{
    add_menu_page(
        'آکادمی سیبانه',
        'آکادمی سیبانه',
        'manage_options',
        'sibanehAcademy',
        'wbsSibanehAcademy',
        get_template_directory_uri() . '/images/temp/sibaneh-logo.png',
        2
    );
    add_submenu_page(
        'sibanehAcademy',
        'دنیای اپلیکیشن و بازی‌ها',
        'دنیای اپلیکیشن و بازی‌ها',
        'manage_options',
        'hubOfTheWorldOfApplicationsAndGames',
        'wbsSibanehTableOfContents'
    );
    add_submenu_page(
        'sibanehAcademy',
        'آموزش‌های جامع اپل',
        'آموزش‌های جامع اپل',
        'manage_options',
        'comprehensiveAppleTutorials',
        'wbsSibanehTableOfContents'
    );
    add_submenu_page(
        'sibanehAcademy',
        'اخبار و تحلیل‌ها',
        'اخبار و تحلیل‌ها',
        'manage_options',
        'newsAndAnalysis',
        'wbsSibanehTableOfContents'
    );
}

add_action('admin_menu', 'wbsSibanehAcademyMenu');

function wbsRemoveDuplicateSibanehAcademySubmenu() {
    remove_submenu_page( 'sibanehAcademy', 'sibanehAcademy' );
}
add_action('admin_menu', 'wbsRemoveDuplicateSibanehAcademySubmenu', 999);

function wbsSibanehAcademy()
{
    require_once THEME_TEMPLATE . "admin/sibaneh/admin.php";
}

function wbsSibanehTableOfContents()
{
    require_once THEME_LIB_DIR . 'tableOfContents/template/tableOfContents-admin.php';
}

add_action('admin_head', function () {
    ?>
    <style>
        /* Force Sibaneh menu icon to be centered and grayscale */
        #toplevel_page_sibanehAcademy .wp-menu-image img {
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
