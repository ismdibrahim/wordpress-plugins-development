<?php 
/**
 * Plugin Name: Our First Plugin
 * plugin URI:https://mdibrahim.net/our-first-plugin
 * Description: This is my first plugin
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Ibrahim Hossen
 * Author URI: https://mdibrahim.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: our-first-plugin
 * Domain Path: /languages
*/

// if(!class_exists('OFP_Change_Content')){
class OFP_Change_Content{
    public function __construct(){
        // add_filter('the_content', array($this, 'change_content'));
        add_action('init', array($this, 'init'));
    }
    public function init(){
        add_filter('the_content', array($this, 'change_content'));
        add_filter('the_title', array($this, 'change_title'));
    }
    public function change_content($content){
        if(!is_singular('post')){
            return $content;
        }
        $id = get_the_ID();
        $custom_content = '';
        $custom_content .= '<div style="border:1px solid #ddd; padding: 10px; margin: 20px 0px;">';
        $custom_content .= '<p>Post ID: '.$id.'</p>';
        $custom_content .= '<p>This is my custom content.</p>';
        $custom_content .= '</div>';
        $content .= $custom_content;

        return $content;
    }

    public function change_title($title){
        if(!is_page()){
            return $title;
        }
        $title .= '!!!';
        return $title;
    }
}

new OFP_Change_Content();

// }