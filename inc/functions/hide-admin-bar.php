<?php
add_action('after_setup_theme', 'wbs_remove_admin_bar');
function wbs_remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}