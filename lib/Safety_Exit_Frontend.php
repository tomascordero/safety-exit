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

	private $defaultSettings;

	public function __construct($file) {
		$this->pluginRoot = $file;
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
		add_action('wp_head', array($this, 'safety_exit_custom_styling'));
		// add_action( 'wp_body_open', array($this, 'safety_exit_inject'), 100 );
		do_action( 'qm/debug', 'wp_body_open fired' );
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
	public function safety_exit_custom_styling() {
		do_action( 'qm/debug', 'generating custom CSS' );

		$classes = $this->defaultSettings['sftExt_position'] . ' ' . $this->defaultSettings['sftExt_type'];
		$icon = '';
		if($this->defaultSettings['sftExt_rectangle_icon_onOff'] == 'yes' && $this->defaultSettings['sftExt_type'] == 'rectangle') {
			$icon = '<i class="' . $this->defaultSettings['sftExt_fontawesome_icon_classes'] . '"></i>';
		}else if($this->defaultSettings['sftExt_type'] == 'round' || $this->defaultSettings['sftExt_type'] == 'square'){
			$icon = '<i class="' . $this->defaultSettings['sftExt_fontawesome_icon_classes'] . '"></i>';
		}
		$displayButton = true;
		if($this->defaultSettings['sftExt_show_all'] == 'no'){
			if( !in_array(get_the_ID(), $this->defaultSettings['sftExt_pages'])){
				$displayButton = false;
			}
		}
		$hideOnMobile = false;
		if($this->defaultSettings['sftExt_hide_mobile'] == 'yes') {
			$hideOnMobile = true;
		}

		// if is_front_page() and "show on front page option is selected"
		if($this->defaultSettings['sftExt_front_page'] == 'yes' && is_front_page()){
			$displayButton = true;
		} elseif ($this->defaultSettings['sftExt_front_page'] == 'no' && is_front_page()) {
			$displayButton = false;
		}
		?>
		<script>
			window.sftExtBtn =  {};
			window.sftExtBtn.classes = '<?= $classes ?>';
			window.sftExtBtn.icon = '<?= $icon ?>';
			window.sftExtBtn.newTabUrl = "<?= $this->defaultSettings['sftExt_new_tab_url'] ?>";
			window.sftExtBtn.currentTabUrl = "<?= $this->defaultSettings['sftExt_current_tab_url']?>";
			window.sftExtBtn.btnType = "<?= $this->defaultSettings['sftExt_type'] ?>";
			window.sftExtBtn.text = "<?= $this->defaultSettings['sftExt_rectangle_text'] ?>";
			window.sftExtBtn.shouldShow = <?= $displayButton ?>;
		</script>
		<style>
			:root {
				--sftExt_bgColor: <?= $this->defaultSettings['sftExt_bg_color'] ?>;
				--sftExt_textColor: <?= $this->defaultSettings['sftExt_font_color'] ?>;
				--sftExt_active: <?= !$displayButton ? 'none !important' : 'inline-block' ?>;
				--sftExt_activeMobile: <?= $hideOnMobile ? 'none !important' : 'inline-block' ?>;
				--sftExt_mobileBreakPoint: 600px;
				--sftExt_rectangle_fontSize: <?= $this->defaultSettings['sftExt_rectangle_font_size'] . $this->defaultSettings['sftExt_rectangle_font_size_units'] ?>;
				--sftExt_rectangle_letterSpacing: <?= $this->defaultSettings['sftExt_letter_spacing'] ?>;
				--sftExt_rectangle_borderRadius: <?= $this->defaultSettings['sftExt_border_radius']; ?>px;
			}
		</style>
		<?php
		do_action( 'qm/debug', 'custom CSS generated' );
	}
	public function safety_exit_inject() {
		do_action( 'qm/debug', 'frontend-button.php before include' );
		include( 'views/frontend-button.php' );
		do_action( 'qm/debug', 'frontend-button.php included' );
	}

}
