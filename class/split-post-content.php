<?php
/**
 * Split post content into two parts: component-content and pagebody-copy
 */
function split_post_content() {
    $content = get_the_content();

    // Early return if no content or it's too short
    if (empty($content) || strlen(trim($content)) < 10) {
    return array(
            'component' => $content,
            'pagebody' => ''
    );
}

    $component_content = '';
    $pagebody_content = '';
    
    // Check for more tag existence
    if (strpos($content, '<!--more-->') !== false) {
        $content_parts = explode('<!--more-->', $content);
        $component_content = apply_filters('the_content', $content_parts[0]);
        if (isset($content_parts[1])) {
            $pagebody_content = apply_filters('the_content', $content_parts[1]);
            $pagebody_content = process_pagebody_content($pagebody_content);
        }
    } else {
        // If no more tag exists, split content based on first paragraph
        $content = apply_filters('the_content', $content);
        
        // Find first </p> tag
        $first_p_end = strpos($content, '</p>');
        
        if ($first_p_end !== false) {
            // First paragraph
            $component_content = substr($content, 0, $first_p_end + 4);
            
            // Remaining content
            $remaining_content = substr($content, $first_p_end + 4);
            if (!empty(trim($remaining_content))) {
                $pagebody_content = process_pagebody_content($remaining_content);
            }
        } else {
            // If no p tag exists, split based on words
            $words = explode(' ', strip_tags($content));
            if (count($words) > 30) { 
                // First 30 words
                $first_words = array_slice($words, 0, 30);
                $component_content = '<p>' . implode(' ', $first_words) . '</p>';
                
                // Remaining words
                $remaining_words = array_slice($words, 30);
                $remaining_content = '<p>' . implode(' ', $remaining_words) . '</p>';
                $pagebody_content = process_pagebody_content($remaining_content);
            } else {
                // If less than 30 words, put all content in component
                $component_content = $content;
            }
        }
    }
    
    return array(
        'component' => $component_content,
        'pagebody' => $pagebody_content
    );
}

/**
 * Process pagebody content: add ul titles and wrap elements
 */
function process_pagebody_content($content) {
    // Add title before ul tags
    $content = add_ul_title($content);
    // Wrap content elements
    return wrap_content_elements($content);
}

/**
 * Add title before ul tags
 */
function add_ul_title($content) {
    $ul_pattern = '/(<ul[^>]*>)/i';
return preg_replace($ul_pattern, '<h4 class="list-title"><i class="icon-menu"></i>فهرست مطالب</h4>$1', $content, 1);
}

/**
 * Wrap content elements (h1, h2, h3, h4) in div containers
 */
function wrap_content_elements($content) {
    // Check if content already has headlines-wrapper to avoid double wrapping
    if (strpos($content, 'headlines-wrapper') !== false) {
        return $content;
    }
    
    $pattern = '/(<(h[1-4])[^>]*>.*?<\/\2>)/s';
    
    $wrapped_content = preg_replace_callback($pattern, function($matches) {
        return '<div class="headlines-wrapper">' . $matches[1] . '</div>';
    }, $content);
    
    return $wrapped_content;
}
