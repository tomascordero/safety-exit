<?php

namespace SafetyExit;

class Frontend {
	private $defaultSettings;
	private $classes = '';
	private $displayButton = true;
	private $icon = '';
	private $hideOnMobile = false;

	public function __construct()
	{
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

		add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
		do_action( 'qm/debug', 'wp_enqueue_scripts fired' );
		add_action('wp_head', array($this, 'runSetup'));
		add_action('wp_head', array($this, 'outputStyles'));
		add_action( 'wp_body_open', array($this, 'outputHtml'), 100 );
		do_action( 'qm/debug', 'wp_body_open fired' );
	}

	public function enqueueScripts()
	{
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
	public function outputStyles()
	{
		if ($this->displayButton) {
			echo $this->generateJs();
			echo $this->generateCss();
		}
	}
	public function outputHtml()
	{
		if ($this->displayButton) {
			echo $this->generateHtml();
		}
	}

	/**
	 * Method runSetup
	 *
	 * @return void
	 */
	public function runSetup()
	{
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

	/**
	 * Method generateJs
	 *
	 * Creates the JS object that will be used to configure the frontend button
	 *
	 * @return string
	 */
	private function generateJs()
	{
		do_action( 'qm/debug', 'generating JS' );
		$jsSettings = [
			'classes' => $this->classes,
			'icon' => $this->icon,
			'newTabUrl' => esc_attr( $this->defaultSettings['sftExt_new_tab_url'] ),
			'currentTabUrl' => esc_attr( $this->defaultSettings['sftExt_current_tab_url'] ),
			'btnType' => esc_attr( $this->defaultSettings['sftExt_type'] ),
			'text' => esc_attr( $this->defaultSettings['sftExt_rectangle_text'] ),
			'shouldShow' => $this->displayButton
		];
		$js = '<script>window.sftExtBtn=' . json_encode($jsSettings) . ';</script>';
		return $js;
	}

	/**
	 * Method generateCss
	 *
	 * Creates the CSS variables that will be used to style the frontend button
	 *
	 * @return string
	 */
	private function generateCss()
	{
		do_action( 'qm/debug', 'generating custom CSS' );
		$cssVariables = [
			'bgColor' => $this->defaultSettings['sftExt_bg_color'],
			'textColor' => $this->defaultSettings['sftExt_font_color'],
			'active' => $this->displayButton ? 'inline-block' : 'none !important',
			'activeMobile' => $this->hideOnMobile ? 'none !important' : 'inline-block',
			'mobileBreakPoint' => '600px',
			'rectangle_fontSize' => $this->defaultSettings['sftExt_rectangle_font_size'] . $this->defaultSettings['sftExt_rectangle_font_size_units'],
			'rectangle_letterSpacing' => $this->defaultSettings['sftExt_letter_spacing'],
			'rectangle_borderRadius' => $this->defaultSettings['sftExt_border_radius'] . 'px'
		];
		$css = '<style>:root{' . $this->arrayToCss($cssVariables, '--sftExt_') . '}</style>';
		return $css;
	}

	private function generateHtml()
	{
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

	private function arrayToCss($array, $prefix = '')
	{
		$css = '';
		foreach ($array as $key => $value) {
			$css .= $prefix . $key . ':' . esc_attr($value) . ';';
		}
		return $css;
	}
}
