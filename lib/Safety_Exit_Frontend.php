<?php
/**
 * Handle all frontend stuff
 *
 * @package Frontend_stuff
 */

/**
 * Creates the submenu item for the plugin.
 *
 * @package Frontend_stuff
 */
class Safety_Exit_Frontend {

	private $pluginRoot;

	private $buttonInitialized = false;

	public function __construct($file) {
		$this->pluginRoot = $file;
	}
	function checkTheme() {
		$themeName = wp_get_theme()->get( 'Name' );

		$themes = [
			'divi'
		];

		return in_array(strtolower($themeName), $themes);
	}

	public function init() {
		add_action('wp_enqueue_scripts', array($this, 'sftExt_enqueue'));
		add_action( 'wp_body_open', array($this, 'safety_exit_inject'), 100 );
		do_action( 'wp_body_open' );
    }
	public function sftExt_enqueue() {
		wp_enqueue_style('frontendCSS', plugins_url() . '/safety-exit/assets/css/frontend.css');
		wp_enqueue_script( 'frontendJs', plugins_url() . '/safety-exit/assets/js/frontend.js', array('jquery') );

		$args = wp_parse_args(get_option('sftExt_settings'), array(
        	'sftExt_rectangle_icon_onOff' => 'yes'
		));

		if(isset($args['sftExt_rectangle_icon_onOff']) && $args['sftExt_rectangle_icon_onOff'] !== 'no') {
			wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/css/all.css' );
		}
	}
	public function safety_exit_inject() {
		include_once( 'views/frontend-button.php' );
	}

}
