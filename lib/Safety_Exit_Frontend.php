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

	private $pluginRoot;

    public function __construct($file) {
		$this->pluginRoot = $file;
    }
// ref: https://wordpress.stackexchange.com/questions/1445/how-do-i-add-css-options-to-my-plugin-without-using-inline-styles
    public function init() {
		add_action('wp_enqueue_scripts', array($this, 'sftExt_enqueue'));
		add_action( 'wp_footer', array($this, 'safety_exit_injectTest'), 100 );
    }
	public function sftExt_enqueue() {
		wp_enqueue_style('frontendCSS', plugins_url() . '/safety-exit/assets/css/frontend.css');
		wp_enqueue_style('frontendOptions', plugins_url() . '/safety-exit/assets/css/generated.css', array('frontendCSS'));
		wp_enqueue_script( 'frontendJs', plugins_url() . '/safety-exit/assets/js/frontend.js', array('jquery') );
		wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/css/all.css' );
	}
	public function safety_exit_injectTest() {
		include_once( 'views/frontend-button.php' );
	}

}