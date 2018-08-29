<?php
/**
 * Handle all frontend stuff
 *
 * @package Frontend_stuff
 */

/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package Frontend_stuff
 */
class Safety_Exit_Frontend {

    public function __construct() {
    }
// ref: https://wordpress.stackexchange.com/questions/1445/how-do-i-add-css-options-to-my-plugin-without-using-inline-styles
    public function init() {
		add_action('wp_enqueue_scripts', array($this, 'enqueue'));
		add_action( 'wp_footer', array($this, 'safety_exit_injectTest'), 100 );
    }
	public function enqueue() {
		wp_enqueue_style( 'frontendJs', plugin_dir_path( __FILE__ ) . 'assets/js/frontend.js' );
		wp_enqueue_script('frontendCss', plugin_dir_path( __FILE__ ) . 'assets/css/frontend.min.css');
	}
	public function safety_exit_injectTest() {
		include_once( 'views/frontend-button.php' );
	}

}