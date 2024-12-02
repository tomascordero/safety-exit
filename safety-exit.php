<?php
/**
 * Safety Exit
 *
 * @package   SafetyExit
 * @author    Tomas Cordero
 * @copyright Copyright (c) 2021 Tomas Cordero
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Safety Exit
 * Plugin URI:
 * Description: This plugin will inject a button on your website that will allow a website user to quickly navigate away from your website.
 * Version:     1.7.1
 * Author:      Tomas Cordero
 * Author URI:  https://tomascordero.com
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: safety-exit
 */
require plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';

use SafetyExit\Frontend;
use SafetyExit\Admin;

// If this file is called directly, abort.
if ( !defined('WPINC') ) {
	die;
}

add_action('plugins_loaded', 'initSafetyExit');

function initSafetyExit() {
    $url_path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
    if ( is_admin() ){
        if(current_user_can('administrator')){
            $admin = new Admin();
        }
    } else if (
        $url_path !== '/wp-login.php'
        && $url_path !== '/admin'
        && $url_path !== '/wp-admin'
        && $url_path !== '/login'
    ){
        $frontend = new Frontend();
        $frontend->init();
    }
}
