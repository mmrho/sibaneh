<?php
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
}

add_action('init', 'register_my_menus');
function register_my_menus()
{
    register_nav_menus(
        array(
            'main-menu' => 'منوی اصلی',
        )
    );
}
