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
	public function init() {
		add_action('wp_enqueue_scripts', array($this, 'sftExt_enqueue'));
		do_action( 'qm/debug', 'wp_enqueue_scripts fired' );
		add_action('wp_head', array($this, 'safety_exit_custom_css'));
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
	public function safety_exit_custom_css() {
		do_action( 'qm/debug', 'generating custom CSS' );
		$sftExtSettings = wp_parse_args(get_option('sftExt_settings'), array(
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
		$hideOnMobile = false;
		if($sftExtSettings['sftExt_hide_mobile'] == 'yes') {
			$hideOnMobile = true;
		}
		// TODO: Keep migrating stuff
		?>
		<style>
			#sftExt-frontend-button {
				background-color: <?= $sftExtSettings['sftExt_bg_color'] ?>;
				color: <?= $sftExtSettings['sftExt_font_color'] ?>;
			}
			<?php if($hideOnMobile) : ?>
			@media (max-width: 600px) {
				#sftExt-frontend-button {
					display: none !important;
				}
			}
			<?php endif; ?>
			#sftExt-frontend-button.rectangle {
				font-size: <?= $sftExtSettings['sftExt_rectangle_font_size'] . $sftExtSettings['sftExt_rectangle_font_size_units']  ; ?>;
				letter-spacing: <?= $sftExtSettings['sftExt_letter_spacing']; ?>;
				border-radius: <?= $sftExtSettings['sftExt_border_radius']; ?>px;
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
