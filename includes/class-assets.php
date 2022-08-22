<?php
namespace BookShop\Includes;

class Assets{
    
    // Register all the plugins assets
    public static function register($file){
        add_action('wp_enqueue_scripts', function() use ($file){
            wp_register_style('bookshop-css', plugin_dir_url($file).'assets/css/custom.css');
            wp_register_script('bookshop-js', plugin_dir_url($file).'assets/js/custom.js');
            wp_localize_script('bookshop-js', 'bookshop', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('bookshopobject'),
            ));
        });
    }
    
    // Load the assets when neccessary
    public static function load(){
		wp_enqueue_style('bookshop-css');
		wp_enqueue_script('bookshop-js');
    }
}