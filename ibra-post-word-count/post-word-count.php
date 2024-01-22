<?php 

/**
 * Plugin Name: Post Word Count
 * plugin URI:https://mdibrahim.net/post-word-count
 * Description: The plugin will add a word count to the end of the post.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Ibrahim Hossen
 * Author URI: https://mdibrahim.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ibra-post-word-count
 * Domain Path: /languages
*/

// register_activation_hook(__FILE__, 'pwc_activation_hook');
// function pwc_activation_hook(){}

// register_deactivation_hook(__FILE__, 'pwc_deactivation_hook');
// function pwc_deactivation_hook(){}

// Plugin loader
add_action('plugins_loaded', 'pwc_plugins_loaded');
function pwc_plugins_loaded(){
    load_plugin_textdomain('ibra-post-word-count', false, dirname(__FILE__)."/languages");
}

// Post word count 
add_filter('the_content', 'pwc_add_post_word_count');
function pwc_add_post_word_count($content){
    $stripped_content = strip_tags($content); //Remove HTML tags
    $word_count = str_word_count($stripped_content); // Count words
    $label = __('Total word count: ', 'ibra-post-word-count');
    $label = apply_filters('pwc_heading', $label); // For user can change the label
    $tag = apply_filters('pwc_tag', 'h3'); // For user can change the tag
    $content .= sprintf('<%s>%s: %s</%s>', $tag, $label, $word_count, $tag);
    return $content;
}

// Post reading time 
add_filter('the_content', 'pwc_add_post_reading_time');
function pwc_add_post_reading_time($content){
    $stripped_content = strip_tags($content); //Remove HTML tags
    $word_count = str_word_count($stripped_content); // Count words
    $reading_minute = floor($word_count/200); // 200 words per minute
    $reading_second = floor($word_count % 200 / (200 / 60)); // 200 words per minute
    $is_visible = apply_filters('readingTime_is_visible', 1); // For user can change the visibility
    if($is_visible){
        $leverl = __('Total Reading time: ', 'ibra-post-word-count'); // Reading time label
        $leverl = apply_filters('readingTime_heading', $leverl); // for user can change the label
        $tag = apply_filters('readingTime_tag', 'h3'); // for user can change the tag
        $content .= sprintf('<%s>%s : %s minutes %s seconds</%s>',$tag, $leverl, $reading_minute, $reading_second, $tag ); // Add reading time to the end of the post
    }
    return $content;
}

