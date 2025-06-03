<?php
/**
 * Split post content into two parts: component-content and pagebody-copy
 */
function split_post_content() {
    $content = get_the_content();
    $component_content = '';
    $pagebody_content = '';
    
    // Check for more tag existence
    if (strpos($content, '<!--more-->') !== false) {
        $content_parts = explode('<!--more-->', $content);
        $component_content = apply_filters('the_content', $content_parts[0]);
        if (isset($content_parts[1])) {
            $pagebody_content = apply_filters('the_content', $content_parts[1]);
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
                $pagebody_content = $remaining_content;
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
                $pagebody_content = '<p>' . implode(' ', $remaining_words) . '</p>';
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
