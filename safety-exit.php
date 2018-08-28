<?php
/**
 * Safety Exit
 *
 * @package   SafetyExit
 * @author    Tomas Cordero
 * @copyright Copyright (c) 2018 Tomas Cordero
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Safety Exit
 * Plugin URI:
 * Description: A safety exit plugin
 * Version:     1.0.0
 * Author:      Tomas Cordero
 * Author URI:  https://tomascordero.com
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: safety-exit
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
foreach ( glob( plugin_dir_path( __FILE__ ) . 'lib/*.php' ) as $file ) {
    include_once $file;
}
if ( is_admin() ){
	$admin = new Safety_Exit_Admin();
    $admin->init();
} else {
  	// non-admin enqueues, actions, and filters
	$frontend = new Safety_Exit_Frontend();
	$frontend->init();
}

// add_action( 'wp_footer', 'safety_exit_injectTest', 100 );


// display button depending on options

// output as floating btn using aside and injecting into footer
// use as menu item
// use as widget
// use shortcode