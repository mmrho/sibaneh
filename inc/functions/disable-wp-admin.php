<?php
function wbs_no_admin_access(): void
{
    if (!wp_doing_ajax()) {
        $redirect = home_url('/my-account/');
        if (!current_user_can('administrator')) {
            exit(wp_redirect($redirect));
        }
    }
}

add_action('admin_init', 'wbs_no_admin_access', 100);