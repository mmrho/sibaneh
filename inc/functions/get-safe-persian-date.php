<?php
function get_safe_persian_date($format, $timestamp = null) {
    if (!$timestamp) $timestamp = time();
    
    if (function_exists('parsidate')) {
        return parsidate($format, $timestamp, 'per');
    } else {
        return date($format, $timestamp);
    }
}
