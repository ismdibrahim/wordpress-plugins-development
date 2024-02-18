<?php 
/**
 * Plugin Name: Tiny Slider Shortcode
 * Plugin URI: https://github.com/ganlanyuan/tiny-slider
 * Description: A simple plugin to add a shortcode for the Tiny Slider library.
 * Version: 1.0
 * Author: Ibrahim Hossen
 * Author URI: http://mdibrahim.net
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tiny-slider-shortcode
 * Domain Path: /languages
*/

class Tiny_Slider_Shortcode{
    public function __construct(){
        add_action('init', array($this, 'init'));
    }
    public function init(){
        add_action('plugins_loaded', [$this, 'load_textdomain']);
        add_action('wp_enqueue_scripts', array($this, 'tss_enqueue_scripts'));
        add_action('init', 'tiny_slider_init');
        add_shortcode('tslider', [$this, 'tslider_shortcode']);
        add_shortcode('tslide', [$this, 'tslide_shortcode']);
    }
    // load text domain
    public function load_textdomain(){
        load_plugin_textdomain('tiny-slider-shortcode', false, dirname(__FILE__). '/languages');
    }
    // load plugin assets
    public function tss_enqueue_scripts(){
        wp_enqueue_style('tiny-slider-css', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css');
        wp_enqueue_script('tiny-slider-js', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', ['jquery'], '2.2.1', true);
        wp_enqueue_script('tiny-slider-main-js', plugin_dir_url(__FILE__). 'assets/js/tinyslider-main.js', ['jquery'], time(), true);
    }

    // tiny slider init
    public function tiny_slider_init(){
        add_image_size('tiny-slider', 800, 400, true);
    }
    // tslider shortcode callback
    public function tslider_shortcode($attr, $content){
        $default_attr = [
            'width' => '600px',
            'height' => 'auto',
            'id' => ''
        ];
        $tslider_attr = shortcode_atts($default_attr, $attr);
        $content = do_shortcode($content);
        
        $shortcode_output = <<<EOD
<div id="{$tslider_attr['id']}" style="width:{$tslider_attr['width']};height:{$tslider_attr['height']}">
        <div class="slider">{$content}</div>
</div>        
EOD;
        return $shortcode_output;
    }

    // tslide shortcode callback
    public function tslide_shortcode($attr){
        $default_attr = [
            'caption' => '',
            'id'    => '',
            'size'  => 'tiny-slider'
        ];
        $tslide_attr = shortcode_atts($default_attr, $attr);
        $image_src = wp_get_attachment_image_src($tslide_attr['id'], $tslide_attr['size']);

        $shortcode_output = <<<EOD
<div class="slide">
    <img src="{$image_src[0]}" alt="{$tslide_attr['caption']}">
    <p>{$tslide_attr['caption']}</p>
</div>
EOD;
        return $shortcode_output;
    }


}

new Tiny_Slider_Shortcode();