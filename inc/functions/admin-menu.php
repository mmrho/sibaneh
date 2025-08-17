<?php

function wbsAdminMenu()
{
    add_menu_page(
        'سیبانه',
        'سیبانه',
        'manage_options',
        'sibaneh.php',
        'wbsSibanehAdmin',
        '',
        2
    );


    require_once THEME_LIB_DIR . 'ctaToClustr/functions/admin-menu.php';
}

add_action('admin_menu', 'wbsAdminMenu');

function wbsSibanehAdmin()
{
    require_once THEME_TEMPLATE . "admin/sibaneh/admin.php";
}

function wbsSibanehCtaToClustr()
{
    require_once THEME_LIB_DIR . 'ctaToClustr/template/ctaToClustr-admin.php';
}
