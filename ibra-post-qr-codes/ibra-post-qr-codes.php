<?php 

/**
 * Plugin Name: Post QR Codes
 * plugin URI:https://mdibrahim.net/post-qr-codes
 * Description: The plugin will add a QR code to the end of the post.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Ibrahim Hossen
 * Author URI: https://mdibrahim.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ibra-post-qr-codes
*/

class Ibra_Post_QR_Code{
    public function __construct(){
        add_action('init', array($this, 'init'));
    }

    public function init(){
        add_filter('the_content', array($this, 'add_post_qr_code'));
    }
    public function add_post_qr_code($content){

        // check post type 
        // if(!is_singular('post')){
        //     return $content;
        // }

        $custom_contet = '';
        $current_link = esc_url(get_the_permalink());
        $current_title = get_the_title();
        $current_post_type = get_post_type(get_the_ID());
        
        // Post type check Hook
        $exclude_post_types = apply_filters('ibra_post_qr_code_exclude_post_types', array());
        if(in_array($current_post_type, $exclude_post_types)){
            return $content;
        }

        // Dimension Hook
        $dimension = apply_filters('ibra_post_qr_code_dimension', '150x150');

        // Image Attribute Hook
        $image_attributes = apply_filters('ibra_post_qr_code_attributes', '');

        // $custom_contet .= '<div style="border:1px solid #ddd; padding: 10px; margin: 20px 0px;">';
        // // $custom_contet .= '<img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl '.$current_link.' " alt="'.$title.'">';
        // // $custom_contet .= '<img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl={$current_link}" alt="{$title}">';
        // $custom_contet .= '<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&color=be185d&data={$current_link}" alt="{$current_title}">';
        // $custom_contet .= '</div>';

        $qrcodes_image = sprintf('https://api.qrserver.com/v1/create-qr-code/?size=%s&color=be185d&data=%s', $dimension, $current_link);
        $content .= sprintf('<div style="border:1px solid #ddd; padding: 10px; margin: 20px 0px;"><img %s src="%s" alt="%s"></div>', $image_attributes, $qrcodes_image, $current_title);

        $content .= $custom_contet;
        return $content;

    }
}

new Ibra_Post_QR_Code();