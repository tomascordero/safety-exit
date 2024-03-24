<?php

namespace SafetyExit;
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

	private $buttonInitialized = false;

	private $defaultSettings;

	private $classes = '';
	private $displayButton = true;
	private $icon = '';
	private $hideOnMobile = false;

	public function __construct() {

		$this->defaultSettings = wp_parse_args(get_option('sftExt_settings'), array(
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
		));


	}
	public function init() {
		add_action('wp_enqueue_scripts', array($this, 'sftExt_enqueue'));
		do_action( 'qm/debug', 'wp_enqueue_scripts fired' );
		add_action('wp_head', array($this, 'echo_safety_exit_custom_styling'));
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
		$this->classes = $this->defaultSettings['sftExt_position'] . ' ' . $this->defaultSettings['sftExt_type'];

		if($this->defaultSettings['sftExt_rectangle_icon_onOff'] == 'yes' && $this->defaultSettings['sftExt_type'] == 'rectangle') {
			$this->icon = '<i class="' . $this->defaultSettings['sftExt_fontawesome_icon_classes'] . '"></i>';
		}else if($this->defaultSettings['sftExt_type'] == 'round' || $this->defaultSettings['sftExt_type'] == 'square'){
			$this->icon = '<i class="' . $this->defaultSettings['sftExt_fontawesome_icon_classes'] . '"></i>';
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
	public function generate_js() {
		do_action( 'qm/debug', 'generating JS' );
		$js = '<script>';
		$js .= 'window.sftExtBtn={};';
		$js .= 'window.sftExtBtn.classes=\'' . $this->classes . '\';';
		$js .= 'window.sftExtBtn.icon=\'' . $this->icon . '\';';
		$js .= 'window.sftExtBtn.newTabUrl=\'' . $this->defaultSettings['sftExt_new_tab_url'] . '\';';
		$js .= 'window.sftExtBtn.currentTabUrl=\'' . $this->defaultSettings['sftExt_current_tab_url'] . '\';';
		$js .= 'window.sftExtBtn.btnType=\'' . $this->defaultSettings['sftExt_type'] . '\';';
		$js .= 'window.sftExtBtn.text=\'' . $this->defaultSettings['sftExt_rectangle_text'] . '\';';
		$js .= 'window.sftExtBtn.shouldShow=' . ($this->displayButton ? 'true' : 'false') . ';';
		$js .= '</script>';
		return $js;
	}



	public function generate_css() {
		do_action( 'qm/debug', 'generating custom CSS' );
		$css = '<style>:root{';
		$css .= '--sftExt_bgColor:' . $this->defaultSettings['sftExt_bg_color'] . ';';
		$css .= '--sftExt_textColor:' . $this->defaultSettings['sftExt_font_color'] . ';';
		$css .= '--sftExt_active:' . (!$this->displayButton ? 'none !important' : 'inline-block') . ';';
		$css .= '--sftExt_activeMobile:' . ($this->hideOnMobile ? 'none !important' : 'inline-block') . ';';
		$css .= '--sftExt_mobileBreakPoint:600px;';
		$css .= '--sftExt_rectangle_fontSize:' . $this->defaultSettings['sftExt_rectangle_font_size'] . $this->defaultSettings['sftExt_rectangle_font_size_units'] .';';
		$css .= '--sftExt_rectangle_letterSpacing:' . $this->defaultSettings['sftExt_letter_spacing'] . ';';
		$css .= '--sftExt_rectangle_borderRadius:' . $this->defaultSettings['sftExt_border_radius'] . 'px;';
		$css .= '}</style>';
		return $css;
	}

	public function generate_html() {
		$html = '<button id="sftExt-frontend-button" class="' . $this->classes . '" data-new-tab="' . $this->defaultSettings['sftExt_new_tab_url'] . '" data-url="' . $this->defaultSettings['sftExt_current_tab_url'] . '">';
		$html .= '<div class="sftExt-inner">';
		$html .= $this->icon ?? '';
		$html .= '<span';
		if ($this->defaultSettings['sftExt_type'] !== 'rectangle') {
			$html .= ' class="sr-only"';
		}
		$html .= '>'. $this->defaultSettings['sftExt_rectangle_text'] .'</span>';
		$html .= '</div>';
		$html .= '</button>';
		return $html;
	}

}
