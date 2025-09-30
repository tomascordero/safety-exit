<?php

namespace SafetyExit;

use SafetyExit\Helpers\Settings;
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
class Frontend {

	private $buttonInitialized = false;

	private $defaultSettings;

	private $classes = '';
	private $displayButton = true;
	private $icon = '';
	private $hideOnMobile = false;

	public function __construct()
	{
		$this->defaultSettings = Settings::getAll();
	}

	public function init() {
		add_action('wp_enqueue_scripts', array($this, 'sftExt_enqueue'));
		do_action( 'qm/debug', 'wp_enqueue_scripts fired' );
		add_action('wp_head', array($this, 'echo_safety_exit_custom_styling'));
		add_action( 'wp_body_open', array($this, 'echo_safety_exit_html'), 100 );
		do_action( 'qm/debug', 'wp_body_open fired' );
    }

	public function run_setup() {

		if(Settings::get('sftExt_show_all') == 'no'){
			if( !in_array(get_the_ID(), Settings::get('sftExt_pages'))){
				$this->displayButton = false;
			} else {
				$this->displayButton = true;
			}
		}

		if(Settings::get('sftExt_front_page') == 'yes' && is_front_page()){
			$this->displayButton = true;
		} else if (Settings::get('sftExt_front_page') == 'no' && is_front_page()) {
			$this->displayButton = false;
		}

		if(Settings::get('sftExt_hide_mobile') == 'yes') {
			$this->hideOnMobile = true;
		}
		$this->classes = esc_attr( Settings::get('sftExt_position') ) . ' ' . esc_attr( Settings::get('sftExt_type') );

		if(Settings::get('sftExt_rectangle_icon_onOff') == 'yes' && Settings::get('sftExt_type') == 'rectangle') {
			$this->icon = '<i class="' . esc_attr( Settings::get('sftExt_fontawesome_icon_classes') ) . '"></i>';
		}else if(Settings::get('sftExt_type') == 'round' || Settings::get('sftExt_type') == 'square'){
			$this->icon = '<i class="' . esc_attr( Settings::get('sftExt_fontawesome_icon_classes') ) . '"></i>';
		}
	}
	public function sftExt_enqueue() {
		if ($this->displayButton) {
			wp_enqueue_style('frontendCSS', plugins_url() . '/safety-exit/assets/css/frontend.css');
			wp_enqueue_script( 'frontendJs', plugins_url() . '/safety-exit/assets/js/frontend.js', array('jquery') );
		}

		$args = wp_parse_args(get_option('sftExt_settings'), array(
        	'sftExt_rectangle_icon_onOff' => 'yes'
		));

		if(isset($args['sftExt_rectangle_icon_onOff']) && $args['sftExt_rectangle_icon_onOff'] !== 'no') {
			wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/css/all.css' );
		}
	}
	public function echo_safety_exit_custom_styling() {
		$this->run_setup();
		echo $this->generate_js();
		echo $this->generate_css();
	}
	public function echo_safety_exit_html() {
		$this->run_setup();
		if ($this->displayButton) {
			echo $this->generate_html();
		}
	}
	public function generate_js() {
		do_action( 'qm/debug', 'generating JS' );

		// Properly escape JavaScript values to prevent XSS
		$jsVars = [
			'classes' => wp_json_encode( $this->classes ),
			'icon' => wp_json_encode( $this->icon ),
			'newTabUrl' => wp_json_encode( Settings::get('sftExt_new_tab_url') ),
			'currentTabUrl' => wp_json_encode( Settings::get('sftExt_current_tab_url') ),
			'btnType' => wp_json_encode( Settings::get('sftExt_type') ),
			'text' => wp_json_encode( Settings::get('sftExt_rectangle_text') ),
			'shouldShow' => ($this->displayButton ? 'true' : 'false'),
		];

		$js = '<script>';
		$js .= 'window.sftExtBtn={};';
		foreach ($jsVars as $key => $value) {
			$js .= 'window.sftExtBtn.' . esc_js( $key ) . '=' . $value . ';';
		}
		$js .= '</script>';
		return $js;
	}



	public function generate_css() {
		do_action( 'qm/debug', 'generating custom CSS' );

		// Validate and sanitize CSS values
		$fontSize = absint( Settings::get('sftExt_rectangle_font_size') );
		$fontSizeUnits = Settings::get('sftExt_rectangle_font_size_units');
		$borderRadius = absint( Settings::get('sftExt_border_radius') );

		// Validate font size units
		$allowedUnits = array( 'px', 'em', 'rem' );
		if ( !in_array( $fontSizeUnits, $allowedUnits ) ) {
			$fontSizeUnits = 'rem';
		}

		$cssVars = [
			'--sftExt_bgColor' 					=> esc_attr( Settings::get('sftExt_bg_color') ),
			'--sftExt_textColor' 				=> esc_attr( Settings::get('sftExt_font_color') ),
			'--sftExt_active' 					=> (!$this->displayButton ? 'none !important' : 'inline-block'),
			'--sftExt_activeMobile'				=> ($this->hideOnMobile ? 'none !important' : 'inline-block'),
			'--sftExt_mobileBreakPoint' 		=> '600px',
			'--sftExt_rectangle_fontSize' 		=> $fontSize . $fontSizeUnits,
			'--sftExt_rectangle_letterSpacing' 	=> esc_attr( Settings::get('sftExt_letter_spacing') ),
			'--sftExt_rectangle_borderRadius' 	=> $borderRadius . 'px',
		];

		$css = '<style>:root{';
		foreach ($cssVars as $key => $value) {
			$css .= esc_attr( $key ) . ':' . $value . ';';
		}
		$css .= '}</style>';
		return $css;
	}

	public function generate_html() {
		$button_classes = esc_attr($this->classes);
		$data_new_tab = esc_attr(Settings::get('sftExt_new_tab_url'));
		$data_url = esc_attr(Settings::get('sftExt_current_tab_url'));
		$icon_html = isset($this->icon) ? $this->icon : '';
		$rectangle_text = esc_attr(Settings::get('sftExt_rectangle_text'));
		$span_class = Settings::get('sftExt_type') !== 'rectangle' ? ' class="sr-only"' : '';

		$html = <<<HTML
	<button id="sftExt-frontend-button" class="$button_classes" data-new-tab="$data_new_tab" data-url="$data_url">
		<div class="sftExt-inner">
			$icon_html<span$span_class>$rectangle_text</span>
		</div>
	</button>
HTML;

		return $html;
	}

}
