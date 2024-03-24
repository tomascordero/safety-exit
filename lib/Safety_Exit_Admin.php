<?php
namespace SafetyExit;

/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package Custom_Admin_Settings
 */
class Safety_Exit_Admin {

    private $root = '';
    private $rootFile = '';
    public function __construct( $file ) {
        $this->root = plugins_url() . '/safety-exit/';
        $this->rootFile = $file;
    }

    public function init() {

        add_action( 'admin_menu', array( $this, 'safety_exit_add_options_page' ) );
        add_action( 'admin_init', array( $this, 'plugin_admin_init') );
        add_action( 'admin_enqueue_scripts',  array( $this, 'plugin_admin_enqueue_scripts') );
        // add_action( 'admin_head-nav-menus.php', array( $this, 'my_register_menu_metabox'), 10, 1  );
        // add_action( 'update_option_sftExt_settings', array($this, 'sftExt_generateCSS') );
    }
    // public function my_register_menu_metabox(  ) {
    //     $custom_param = array( 0 => 'This param will be passed to my_render_menu_metabox' );

	//     add_meta_box(
    //         'my-menu-test-metabox',
    //         'Safety Exit Button',
    //         array( $this, 'my_render_menu_metabox'),
    //         'nav-menus',
    //         'side',
    //         'default',
    //         $custom_param );
    // }

    public function sftExt_generateCSS() {
        // die;
        $options = wp_parse_args(get_option('sftExt_settings'), $this->btnDefaults);
        $cssString = '#sftExt-frontend-button.rectangle{font-size: '. $options['sftExt_rectangle_font_size'] . $options['sftExt_rectangle_font_size_units'] . ';}' ;
        wp_parse_args(update_option('sftExt_settings'), array(
            'sftExt_css' => $cssString
        ));
        // update_option('sftExt_css', $cssString);
    }

    public function safety_exit_add_options_page() {
        // echo $this->root;die;
        add_menu_page(
            'Safety Exit Options',
            'Safety Exit',
            'manage_options',
            'safety_exit',
            function(){
                include_once( 'views/global-settings.php' );
            },
            'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMiAyMiI+PGRlZnM+PHN0eWxlPi5jbHMtMXtmaWxsOiNmZmY7fTwvc3R5bGU+PC9kZWZzPjx0aXRsZT5Bc3NldCAxPC90aXRsZT48ZyBpZD0iTGF5ZXJfMiIgZGF0YS1uYW1lPSJMYXllciAyIj48ZyBpZD0iTGF5ZXJfMS0yIiBkYXRhLW5hbWU9IkxheWVyIDEiPjxnIGlkPSJtaXUiPjxnIGlkPSJBcnRib2FyZC0xIj48cGF0aCBpZD0iY29tbW9uLWxvZ291dC1zaWdub3V0LWV4aXQtZ2x5cGgiIGNsYXNzPSJjbHMtMSIgZD0iTTAsMFYyMkgxNVYxNkgxM3Y0SDJWMkgxM1Y2aDJWMFpNMTUuNjQsNy40NmwxLjQxLTEuNDFMMjIsMTFsLTQuOTUsNC45NS0xLjQxLTEuNDFMMTguMTcsMTJIN1YxMEgxOC4xN1oiLz48L2c+PC9nPjwvZz48L2c+PC9zdmc+'
        );
    }
    public function plugin_admin_enqueue_scripts($hook){
        // echo $hook;die;
        if( $hook == 'toplevel_page_safety_exit' ) {

            wp_enqueue_style('sftExt-admin-icon-picker', $this->root . 'assets/css/fontawesome-iconpicker.css');
            wp_enqueue_style('sftExt-admin-admin', $this->root . 'assets/css/admin.css');
            wp_enqueue_script('sftExt-admin-color-picker', $this->root . 'assets/vendor/vanilla-picker.min.js');
            wp_enqueue_script('sftExt-admin-icon-picker-js', $this->root . 'assets/vendor/fontawesome-iconpicker.min.js');
            wp_register_script('sftExt-admin-js', $this->root . 'assets/js/admin.js', array('jquery', 'sftExt-admin-icon-picker-js', 'sftExt-admin-color-picker'));
            wp_enqueue_script( 'sftExt-admin-js');

            // wp_register_script( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/js/all.js' );
            wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/css/all.css' );

        }
    }
    private $btnDefaults = array(
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
    );

    public function plugin_admin_init(){

        if(current_user_can('administrator')){

            register_setting( 'pluginPage', 'sftExt_settings' );
            $options = wp_parse_args(get_option('sftExt_settings'), $this->btnDefaults);
            $recClasses = '';
            if($options['sftExt_type'] == 'rectangle') {
                $recClasses = 'option-wrapper rectangle-only';
            }else{
                $recClasses = 'option-wrapper rectangle-only hidden';
            }
            add_settings_section(
                'sftExt_pluginPage_section',
                __( 'General Settings', 'wordpress' ),
                array( $this, 'sftExt_settings_section_callback'),
                'pluginPage',
                array( 'section_id' => 'sftExt_pluginPage_section' )
            );

            // Button position

            add_settings_field(
                'sftExt_position',
                __( 'Button Position', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => 'option-wrapper sftExt_position', 'label_for' => 'sftExt_position' )
            );

            // Button Icon
            add_settings_field(
                'sftExt_fontawesome_icon_classes',
                __( 'Button Icon', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => 'option-wrapper sftExt_fontawesome_icon_classes', 'label_for' => 'sftExt_fontawesome_icon_classes' )
            );

            // End Button Icon

            // Button Color
            add_settings_field(
                'sftExt_bg_color',
                __( 'Button Background Color', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => 'option-wrapper sftExt_bg_color', 'label_for' => 'sftExt_bg_color' )
            );
            // End Button Color
            // Button font Color
            add_settings_field(
                'sftExt_font_color',
                __( 'Button Font/Icon Color', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => 'option-wrapper sftExt_font_color', 'label_for' => 'sftExt_font_color' )
            );
            // End Button font Color

            // Button type

            add_settings_field(
                'sftExt_type',
                __( 'Button Type', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => 'option-wrapper sftExt_type', 'label_for' => 'sftExt_type' )
            );
            add_settings_field(
                'sftExt_border_radius',
                __( 'Border Radius', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => $recClasses, 'label_for' => 'sftExt_border_radius' )
            );
            // Rectangle Settings

            add_settings_field(
                'sftExt_rectangle_text',
                __( 'Button Text', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => $recClasses, 'label_for' => 'sftExt_rectangle_text' )
            );

            add_settings_field(
                'sftExt_rectangle_icon_onOff',
                __( 'Include Icon?', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => $recClasses, 'label_for' => 'sftExt_rectangle_icon_onOff' )
            );
            add_settings_field(
                'sftExt_rectangle_font_size',
                __( 'Font Size', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => $recClasses, 'label_for' => 'sftExt_rectangle_font_size' )
            );
            add_settings_field(
                'sftExt_rectangle_font_size_units',
                __( 'Font Size Units', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => $recClasses, 'label_for' => 'sftExt_rectangle_font_size_units' )
            );

            // End Rectangle Settings

            // Redirect URLs
            add_settings_section(
                'sftExt_pluginPage_redirection_options',
                __( 'Redirection Options', 'wordpress' ),
                array( $this, 'sftExt_settings_section_callback'),
                'pluginPage',
                array( 'section_id' => 'sftExt_pluginPage_redirection_options' )
            );

            add_settings_field(
                'sftExt_current_tab_url',
                __( 'Website URL', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_redirection_options',
                array ( 'class' => 'option-wrapper sftExt_current_tab_url', 'label_for' => 'sftExt_current_tab_url' )
            );
            add_settings_field(
                'sftExt_new_tab_url',
                __( 'Website URL', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_redirection_options',
                array ( 'class' => 'option-wrapper sftExt_new_tab_url', 'label_for' => 'sftExt_new_tab_url' )
            );

            // End Button type

            // Button Display Options

            add_settings_section(
                'sftExt_pluginPage_btn_display_options',
                __( 'Button Display Options', 'wordpress' ),
                array( $this, 'sftExt_settings_section_callback'),
                'pluginPage',
                array( 'section_id' => 'sftExt_pluginPage_btn_display_options' )
            );
            add_settings_field(
                'sftExt_hide_mobile',
                __( 'Hide button on mobile?', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_btn_display_options',
                array ( 'class' => 'option-wrapper sftExt_hide_mobile', 'label_for' => 'sftExt_hide_mobile' )
            );
            add_settings_field(
                'sftExt_show_all',
                __( 'Show on all pages?', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_btn_display_options',
                array ( 'class' => 'option-wrapper sftExt_show_all', 'label_for' => 'sftExt_show_all' )
            );
            add_settings_field(
                'sftExt_front_page',
                __( 'Show on Front Page?', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_btn_display_options',
                array ( 'class' => 'option-wrapper sftExt_front_page', 'label_for' => 'sftExt_front_page' )
            );
            add_settings_field(
                'sftExt_pages',
                __( 'Select Pages', 'wordpress' ),
                array( $this, 'sftExt_options_render'),
                'pluginPage',
                'sftExt_pluginPage_btn_display_options',
                array ( 'class' => 'option-wrapper sftExt_pages', 'label_for' => 'sftExt_pages' )
            );

            // End Button Display Options
        }
	}

    function sftExt_options_render( $args ) {
        $options = wp_parse_args(get_option('sftExt_settings'), $this->btnDefaults);

        switch($args['label_for']) {
            case 'sftExt_position':
                ?>
                    <select id="sftExt_position" name='sftExt_settings[sftExt_position]'>
                        <option value='bottom left' <?php selected( $options['sftExt_position'], 'bottom left' ); ?>>Bottom Left</option>
                        <option value='bottom right' <?php selected( $options['sftExt_position'], 'bottom right' ); ?>>Bottom Right</option>
                    </select>

                <?php
                break;
            case 'sftExt_fontawesome_icon_classes':
                ?>
                    <div id="sftExt_icon_display" style="height: 75px;"><i class="fa-3x <?= $options['sftExt_fontawesome_icon_classes']; ?>"></i></div>
                    <!-- <button id="sftExt_fontawesome_icon_classes_btn" >Change Icon</button> -->
                    <input type="hidden" id="sftExt_fontawesome_icon_classes" name="sftExt_settings[sftExt_fontawesome_icon_classes]" value="<?= $options['sftExt_fontawesome_icon_classes']; ?>">

                <?php
                break;
            case 'sftExt_bg_color':
                ?>
                    <div id="sftExt_color_picker_btn_bg_color" style="background-color: <?= $options['sftExt_bg_color']?>">Choose Color</div>
                    <input type="hidden" id="sftExt_bg_color" name="sftExt_settings[sftExt_bg_color]" value="<?= $options['sftExt_bg_color']; ?>">

                <?php
                break;
            case 'sftExt_font_color':
                ?>
                    <div id="sftExt_color_picker_btn_font_color" style="background-color: <?= $options['sftExt_font_color']?>">Choose Color</div>
                    <input type="hidden" id="sftExt_font_color" name="sftExt_settings[sftExt_font_color]" value="<?= $options['sftExt_font_color']; ?>">

                <?php
                break;
            case 'sftExt_type':
                ?>
                    <select id="sftExt_type" name='sftExt_settings[sftExt_type]'>
                        <option value='round' <?php selected( $options['sftExt_type'], 'round' ); ?>>Round</option>
                        <option value='square' <?php selected( $options['sftExt_type'], 'square' ); ?>>Square</option>
                        <option value='rectangle' <?php selected( $options['sftExt_type'], 'rectangle' ); ?>>Rectangle</option>
                    </select>
                <?php
                break;
            case 'sftExt_border_radius':
                ?>
                    <input type="number" id="sftExt_border_radius" name="sftExt_settings[sftExt_border_radius]" value="<?= $options['sftExt_border_radius']; ?>"> px
                <?php
                break;
            case 'sftExt_rectangle_font_size':
                ?>
                    <input type="number" id="sftExt_rectangle_font_size" name="sftExt_settings[sftExt_rectangle_font_size]" value="<?= $options['sftExt_rectangle_font_size']; ?>"> <span class="sftExt_units"><?= $options['sftExt_rectangle_font_size_units']; ?></span>
                <?php
                break;
            case 'sftExt_rectangle_font_size_units':
                ?>
                    <select id="sftExt_rectangle_font_size_units" name='sftExt_settings[sftExt_rectangle_font_size_units]'>
                        <option value='px' <?php selected( $options['sftExt_rectangle_font_size_units'], 'px' ); ?>>px</option>
                        <option value='em' <?php selected( $options['sftExt_rectangle_font_size_units'], 'em' ); ?>>em</option>
                        <option value='rem' <?php selected( $options['sftExt_rectangle_font_size_units'], 'rem' ); ?>>rem</option>
                    </select>
                <?php
                break;
            case 'sftExt_current_tab_url':
                ?>
                    <input type="text" id="sftExt_current_tab_url" name="sftExt_settings[sftExt_current_tab_url]" value="<?= $options['sftExt_current_tab_url']; ?>">
                <?php
                break;
            case 'sftExt_new_tab_url':
                ?>
                    <input type="text" id="sftExt_new_tab_url" name="sftExt_settings[sftExt_new_tab_url]" value="<?= $options['sftExt_new_tab_url']; ?>">
                <?php
                break;
            case 'sftExt_rectangle_text':
                ?>
                    <input type="text" id="sftExt_rectangle_text" name="sftExt_settings[sftExt_rectangle_text]" value="<?= $options['sftExt_rectangle_text']; ?>">
                <?php
                break;
            case 'sftExt_rectangle_icon_onOff':
                ?>
                    <select id="sftExt_rectangle_icon_onOff" name='sftExt_settings[sftExt_rectangle_icon_onOff]'>
                        <option value='no' <?php selected( $options['sftExt_rectangle_icon_onOff'], 'no' ); ?>>No</option>
                        <option value='yes' <?php selected( $options['sftExt_rectangle_icon_onOff'], 'yes' ); ?>>Yes</option>
                    </select>
                <?php
                break;
            case 'sftExt_pages':
                $postIDs = get_posts(array(
                    'fields'          => 'ids', // Only get post IDs
                    'posts_per_page'  => -1,
                    'post_type' => 'any'
                ));

                ?>
                <?php foreach($postIDs as $key => $postID) : ?>
                    <input type="checkbox" name="sftExt_settings[sftExt_pages][]" id="sftExt_pages" value="<?= $postID; ?>" <?= in_array($postID, $options['sftExt_pages']) ? 'checked="checked"': ''?>> <?= get_the_title($postID); ?><br/>
                <?php endforeach; ?>
                <?php
                break;
            case 'sftExt_front_page':
                ?>
                    <input type="radio" name="sftExt_settings[sftExt_front_page]" id="sftExt_front_page" value="yes" <?php checked( $options['sftExt_front_page'], 'yes' ); ?>> Yes<br/>
                    <input type="radio" name="sftExt_settings[sftExt_front_page]" id="sftExt_front_page" value="no" <?php checked( $options['sftExt_front_page'], 'no' ); ?>> No<br/>
                <?php
                break;
            case 'sftExt_show_all':
                ?>
                    <input type="radio" name="sftExt_settings[sftExt_show_all]" id="sftExt_show_all" class="sftExt_show_all" value="yes" <?php checked( $options['sftExt_show_all'], 'yes' ); ?>> Yes<br/>
                    <input type="radio" name="sftExt_settings[sftExt_show_all]" id="sftExt_show_all" class="sftExt_show_all" value="no" <?php checked( $options['sftExt_show_all'], 'no' ); ?>> No<br/>
                <?php
                break;
            case 'sftExt_hide_mobile':
                ?>
                    <input type="checkbox" name="sftExt_settings[sftExt_hide_mobile]" id="sftExt_hide_mobile" class="sftExt_hide_mobile" value="yes" <?php checked( $options['sftExt_hide_mobile'], 'yes' ); ?>> Yes
                <?php
                break;
        }

    }


    function sftExt_settings_section_callback( $args ) {
        switch($args['id']){
            // case 'sftExt_pluginPage_section':
            //     echo __( 'This section description', 'wordpress' );
            //     break;
            case 'sftExt_pluginPage_redirection_options':
                echo __( 'Enter the URLs you want the button to redirect to', 'wordpress' );
                break;
        }

    }
}
