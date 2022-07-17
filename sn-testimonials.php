<?php

/**
* Plugin Name: SN Testimonials
* Plugin URI: https://www.web4you.biz.pl
* Description: Beautiful testimonials
* Version: 1.0
* Requires at least: 5.6
* Requires PHP: 7.0
* Author: Sebastian Nieroda
* Author URI: https://www.web4you.biz.pl
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: sn-testimonials
* Domain Path: /languages
*/
/*
SN Testimonials is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

I hope you enjoy my plugin!
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !class_exists( 'SN_Testimonials' ) ){

    class SN_Testimonials{

        public function __construct() {

            // Define constants used througout the plugin
            $this->define_constants();  

            // Create post type 
            require_once(SN_TESTIMONIALS_PATH.'/post-types/class.sn-testimonials-post-type.php');
            $sn_testimonials_cpt = new SN_Testimonials_Post_Type();
            // Register widget
            require_once(SN_TESTIMONIALS_PATH.'/widgets/class.sn-testimonials-widget.php');
            $SN_Testimonials_Widget = new SN_Testimonials_Widget();
            // Custom templates
            add_filter('archive_template' , array($this , 'load_custom_archive_template')); 
            add_filter('single_template' , array($this , 'load_custom_single_template')); 

        }

         /**
         * Define Constants
         */
        public function define_constants(){
            // Path/URL to root of this plugin, with trailing slash.
            define ( 'SN_TESTIMONIALS_PATH', plugin_dir_path( __FILE__ ) );
            define ( 'SN_TESTIMONIALS_URL', plugin_dir_url( __FILE__ ) );
            define ( 'SN_TESTIMONIALS_VERSION', '1.0.0' );     
        }

        /*
        * Load cuatom  archive template
        */
        public function load_custom_archive_template($template){
            if(current_theme_supports( 'sn-testimonials' )){
                if(is_post_type_archive( 'sn-testimonials' )){
                    $template = SN_TESTIMONIALS_PATH.'views/templates/archive-sn-testimonials.php';
                }
            }
            return $template;
        }

        public function load_custom_single_template($template){
            if(current_theme_supports( 'sn-testimonials' )){
                if(is_singular( 'sn-testimonials' )){
                    $template = SN_TESTIMONIALS_PATH.'views/templates/single-sn-testimonials.php';
                }
            }
            return $template;
        }

        /**
         * Activate the plugin
         */
        public static function activate(){
            update_option('rewrite_rules', '' );
        }

        /**
         * Deactivate the plugin
         */
        public static function deactivate(){
            unregister_post_type( 'sn-testimonials');
            flush_rewrite_rules();
        }

        /**
         * Uninstall the plugin
         */
        public static function uninstall(){
            delete_option( 'widget_sn-testimonials' );
            // Remove all posts related with plugin
            $posts = get_posts( array(
                'post_type' => 'sn-testimonials' ,
                'number_posts' => -1 ,
                'post_status' => 'any'
            ) );

            foreach ($posts as $post) {
                wp_delete_post( $post->ID , true);
            }
        }

    }
}

if( class_exists( 'SN_Testimonials' ) ){
    // Installation and uninstallation hooks
    register_activation_hook( __FILE__, array( 'SN_Testimonials', 'activate'));
    register_deactivation_hook( __FILE__, array( 'SN_Testimonials', 'deactivate'));
    register_uninstall_hook( __FILE__, array( 'SN_Testimonials', 'uninstall' ) );

    $sn_testimonials = new SN_Testimonials();
}