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

		if($this->defaultSettings['sftExt_show_all'] == 'no'){
			if( !in_array(get_the_ID(), $this->defaultSettings['sftExt_pages'])){
				$this->displayButton = false;
			} else {
				$this->displayButton = true;
			}
		}

		if($this->defaultSettings['sftExt_front_page'] == 'yes' && is_front_page()){
			$this->displayButton = true;
		} else if ($this->defaultSettings['sftExt_front_page'] == 'no' && is_front_page()) {
			$this->displayButton = false;
		}

		if($this->defaultSettings['sftExt_hide_mobile'] == 'yes') {
			$this->hideOnMobile = true;
		}
		$this->classes = esc_attr( $this->defaultSettings['sftExt_position'] ) . ' ' . esc_attr( $this->defaultSettings['sftExt_type'] );

		if($this->defaultSettings['sftExt_rectangle_icon_onOff'] == 'yes' && $this->defaultSettings['sftExt_type'] == 'rectangle') {
			$this->icon = '<i class="' . esc_attr( $this->defaultSettings['sftExt_fontawesome_icon_classes'] ) . '"></i>';
		}else if($this->defaultSettings['sftExt_type'] == 'round' || $this->defaultSettings['sftExt_type'] == 'square'){
			$this->icon = '<i class="' . esc_attr( $this->defaultSettings['sftExt_fontawesome_icon_classes'] ) . '"></i>';
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
		$js = '<script>';
		$js .= 'window.sftExtBtn={};';
		$js .= 'window.sftExtBtn.classes=\'' . $this->classes . '\';';
		$js .= 'window.sftExtBtn.icon=\'' . $this->icon . '\';';
		$js .= 'window.sftExtBtn.newTabUrl=\'' . esc_attr( $this->defaultSettings['sftExt_new_tab_url'] ) . '\';';
		$js .= 'window.sftExtBtn.currentTabUrl=\'' . esc_attr( $this->defaultSettings['sftExt_current_tab_url'] ) . '\';';
		$js .= 'window.sftExtBtn.btnType=\'' . esc_attr( $this->defaultSettings['sftExt_type'] ) . '\';';
		$js .= 'window.sftExtBtn.text=\'' . esc_attr( $this->defaultSettings['sftExt_rectangle_text'] ) . '\';';
		$js .= 'window.sftExtBtn.shouldShow=' . ($this->displayButton ? 'true' : 'false') . ';';
		$js .= '</script>';
		return $js;
	}



	public function generate_css() {
		do_action( 'qm/debug', 'generating custom CSS' );
		$css = '<style>:root{';
		$css .= '--sftExt_bgColor:' . esc_attr( $this->defaultSettings['sftExt_bg_color'] ) . ';';
		$css .= '--sftExt_textColor:' . esc_attr( $this->defaultSettings['sftExt_font_color'] ) . ';';
		$css .= '--sftExt_active:' . (!$this->displayButton ? 'none !important' : 'inline-block') . ';';
		$css .= '--sftExt_activeMobile:' . ($this->hideOnMobile ? 'none !important' : 'inline-block') . ';';
		$css .= '--sftExt_mobileBreakPoint:600px;';
		$css .= '--sftExt_rectangle_fontSize:' . esc_attr( $this->defaultSettings['sftExt_rectangle_font_size'] ) . esc_attr( $this->defaultSettings['sftExt_rectangle_font_size_units'] ) .';';
		$css .= '--sftExt_rectangle_letterSpacing:' . esc_attr( $this->defaultSettings['sftExt_letter_spacing'] ) . ';';
		$css .= '--sftExt_rectangle_borderRadius:' . esc_attr( $this->defaultSettings['sftExt_border_radius'] ) . 'px;';
		$css .= '}</style>';
		return $css;
	}

	public function generate_html() {
		$html = '<button id="sftExt-frontend-button" class="' . $this->classes . '" data-new-tab="' . esc_attr( $this->defaultSettings['sftExt_new_tab_url'] ) . '" data-url="' . esc_attr( $this->defaultSettings['sftExt_current_tab_url'] ) . '">';
		$html .= '<div class="sftExt-inner">';
		$html .= $this->icon ?? '';
		$html .= '<span';
		if ($this->defaultSettings['sftExt_type'] !== 'rectangle') {
			$html .= ' class="sr-only"';
		}
		$html .= '>'. esc_attr( $this->defaultSettings['sftExt_rectangle_text'] ) .'</span>';
		$html .= '</div>';
		$html .= '</button>';
		return $html;
	}

}
