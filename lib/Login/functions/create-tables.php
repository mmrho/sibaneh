<?php
/*
function wbs_create_verifications_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'wbs_verifications';
    $charset_collate = $wpdb->get_charset_collate();

    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $sql = "
            CREATE TABLE {$table_name} (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                phone VARCHAR(15) NOT NULL,
                code CHAR(5) NOT NULL,
                status VARCHAR(20) NOT NULL DEFAULT 'pending',
                PRIMARY KEY (id),
                INDEX (phone)
            ) $charset_collate;
        ";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once trailingslashit( ABSPATH ) . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $sql );
    }
}

add_action( 'after_switch_theme', 'wbs_create_verifications_table' );
*/