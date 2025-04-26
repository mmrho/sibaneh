<?php
add_action('init', 'initEverything');
function initEverything()
{
    if (!session_id()) {
        session_start();
    }
}