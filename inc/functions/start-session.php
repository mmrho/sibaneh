<?php
add_action('init', function() {
    if (!session_id()) {
        session_start();
    }
});