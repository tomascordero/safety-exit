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
 * Version:     1.6.2-beta
 * Author:      Tomas Cordero
 * Author URI:  https://tomascordero.com
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: safety-exit
 */

$path = realpath(dirname(__FILE__) . '/../../../')."/wp-includes/pluggable.php";

// This adds support for bedrock, ABSPATH is set by bedrock as part of the config.
if(defined('ABSPATH')){
    $path = ABSPATH . '/wp-includes/pluggable.php';
}

$errors = false;
// Check to see if required file exists. If not do not initialize plugin
try {
    if( !file_exists( $path ) ) {
        throw new Exception ('Unable to load pluggable.php in: ' . $path . ' Safety Exit is disabled until this error is fixed.');
    }else{
        require_once($path);
    }
}catch(Exception $e){
    if ( is_admin() ){
        ?>
        <div class="error notice">
            <p><?= $e->getMessage(); ?></p>
        </div>
        <?php
    }
    $errors = true;
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
foreach ( glob( plugin_dir_path( __FILE__ ) . 'lib/*.php' ) as $file ) {
    include_once $file;
}
if( !$errors ) {
	if ( is_admin() ){
		if(current_user_can('administrator')){
			$admin = new Safety_Exit_Admin(__FILE__);
			$admin->init();
		}
	} else {
		$frontend = new Safety_Exit_Frontend(__FILE__);
		$frontend->init();
	}
}
