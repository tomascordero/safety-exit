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
 * Version:     1.9.0
 * Author:      Tomas Cordero
 * Author URI:  https://tomascordero.com
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: safety-exit
 */

if ( ! defined( 'WPINC' ) ) { die; }

define('SAFETY_EXIT_VERSION', '1.9.0');

require plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';

use SafetyExit\Frontend;
use SafetyExit\Admin;
use SafetyExit\Helpers\Settings;

// This adds support for bedrock, ABSPATH is set by bedrock as part of the config.
if(defined('ABSPATH')){
    $path = ABSPATH . '/wp-includes/pluggable.php';
}

function safety_exit_activate() {
    add_option('sftExt_settings', Settings::getDefaults());
    add_option('sftExt_version', SAFETY_EXIT_VERSION);
}
register_activation_hook( __FILE__, 'safety_exit_activate' );

function safety_exit_uninstall() {
    delete_option('sftExt_settings');
    delete_option('sftExt_version');
}
register_uninstall_hook( __FILE__, 'safety_exit_uninstall' );

if ( ! file_exists( $path ) ) {
    add_action( 'admin_notices', function() use ( $path ) {
        $message = sprintf(
            /* translators: %s: path to pluggable.php */
            __( 'Safety Exit: Unable to load pluggable.php from %s. The plugin is disabled until this error is fixed.', 'safety-exit' ),
            esc_html( $path )
        );
        printf( '<div class="notice notice-error"><p>%s</p></div>', $message );
    } );
    return;
}

require_once $path;

if ( is_admin() ) {
    if ( current_user_can( 'manage_options' ) ) {
        $admin = new Admin( __FILE__ );
        $admin->init();
    }
} else {
    $frontend = new Frontend( __FILE__ );
    $frontend->init();
}
