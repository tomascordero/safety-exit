<?php

namespace SafetyExit\Controllers;

use Symfony\Component\VarDumper\VarDumper as DD;

class AdminController
{
    private $btnDefaults = [];

    private $root;

    public function __construct()
    {
        $this->root = plugins_url() . '/safety-exit/';
        add_action( 'admin_menu', array( $this, 'addMenuPages' ) );
        add_action( 'admin_init', array( $this, 'init') );
        add_action( 'admin_enqueue_scripts',  array( $this, 'enqueueScripts') );

        $this->btnDefaults = [
            'sftExt_position' => 'bottom right',
            'sftExt_fontawesome_icon_classes' => 'fas fa-times',
            'sftExt_type' => 'rectangle',
            'sftExt_current_tab_url' => 'https://google.com',
            'sftExt_new_tab_url' => 'https://google.com',
            'sftExt_rectangle_text' => 'Safety Exit',
            'sftExt_rectangle_icon_onOff' => 'yes',
            'sftExt_rectangle_font_size_units' => 'rem',
            'sftExt_rectangle_font_size' => '1',
            'sftExt_bg_color' => 'rgba(58, 194, 208, 1)',
            'sftExt_font_color' => 'rgba(255, 255, 255, 1)',
            'sftExt_letter_spacing' => 'inherit',
            'sftExt_border_radius' => '100',
            'sftExt_hide_mobile' => '',
            'sftExt_show_all' => 'yes',
            'sftExt_front_page' => 'yes',
            'sftExt_pages' => array()
        ];

    }

    public function addMenuPages() {
        add_menu_page(
            'Safety Exit Options',
            'Safety Exit',
            'manage_options',
            'safety_exit',
            function(){
                include_once( 'views/global-settings.php' );
            },
            'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMiAyMiI+PGRlZnM+PHN0eWxlPi5jbHMtMXtmaWxsOiNmZmY7fTwvc3R5bGU+PC9kZWZzPjx0aXRsZT5Bc3NldCAxPC90aXRsZT48ZyBpZD0iTGF5ZXJfMiIgZGF0YS1uYW1lPSJMYXllciAyIj48ZyBpZD0iTGF5ZXJfMS0yIiBkYXRhLW5hbWU9IkxheWVyIDEiPjxnIGlkPSJtaXUiPjxnIGlkPSJBcnRib2FyZC0xIj48cGF0aCBpZD0iY29tbW9uLWxvZ291dC1zaWdub3V0LWV4aXQtZ2x5cGgiIGNsYXNzPSJjbHMtMSIgZD0iTTAsMFYyMkgxNVYxNkgxM3Y0SDJWMkgxM1Y2aDJWMFpNMTUuNjQsNy40NmwxLjQxLTEuNDFMMjIsMTFsLTQuOTUsNC45NS0xLjQxLTEuNDFMMTguMTcsMTJIN1YxMEgxOC4xN1oiLz48L2c+PC9nPjwvZz48L2c+PC9zdmc+'
        );
    }

    public function init(){
        if(current_user_can('administrator')){
            register_setting( 'pluginPage', 'sftExt_settings' );
        }
	}

    public function fetchManifest() {
        // DD::dump(plugin_dir_path(__FILE__) . '../../dist/.vite/manifest.json');
        // exit();
        $manifest = json_decode(file_get_contents(plugin_dir_path(__FILE__) . '../../dist/.vite/manifest.json'), true);
        DD::dump($manifest);
        exit();
        // return $manifest;
    }

    public function enqueueScripts($hook){
        // echo $hook;die;
        $this->fetchManifest();
        if( $hook == 'toplevel_page_safety_exit' ) {

            // wp_enqueue_style('sftExt-admin-icon-picker', $this->root . 'assets/css/fontawesome-iconpicker.css');
            // wp_enqueue_style('sftExt-admin-admin', $this->root . 'assets/css/admin.css');
            // wp_enqueue_script('sftExt-admin-color-picker', $this->root . 'assets/vendor/vanilla-picker.min.js');
            // wp_enqueue_script('sftExt-admin-icon-picker-js', $this->root . 'assets/vendor/fontawesome-iconpicker.min.js');
            wp_register_script('sftExt-admin-js', $this->root . 'assets/js/admin.js', array('jquery', 'sftExt-admin-icon-picker-js', 'sftExt-admin-color-picker'));
            wp_enqueue_script( 'sftExt-admin-js');

            // wp_register_script( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/js/all.js' );
            wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/css/all.css' );

        }
    }
}
