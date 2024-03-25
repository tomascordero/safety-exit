<?php

namespace SafetyExit\Controllers;

class AdminController
{
    private $btnDefaults = [];

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'addMenuPages' ) );
        add_action( 'admin_init', array( $this, 'plugin_admin_init') );
        add_action( 'admin_enqueue_scripts',  array( $this, 'plugin_admin_enqueue_scripts') );

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
        ]

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

    public function plugin_admin_init(){

        if(current_user_can('administrator')){
            register_setting( 'pluginPage', 'sftExt_settings' );
        }
	}
}
