<?php
namespace SafetyExit;

use SafetyExit\Util\Config;

class Admin {

    private $root = '';

    private $defaults = [];

    public function __construct()
    {
        $this->root = plugins_url() . '/safety-exit/';
        $this->defaults = Config::get('defaults');

        register_activation_hook(__FILE__, array($this, 'initialize_settings'));

        // Hook to check settings on plugin load
        add_action('plugins_loaded', array($this, 'check_settings_on_load'));

        add_action( 'admin_menu', array( $this, 'addOptionsPage' ) );
        add_action( 'admin_init', array( $this, 'adminInit') );
        add_action( 'admin_enqueue_scripts',  array( $this, 'enqueScripts') );
    }

    public function initialize_settings() {
        $default_settings = $this->defaults;

        if (get_option('sftExt_settings') === false) {
            add_option('sftExt_settings', $default_settings);
        }
    }

    public function check_settings_on_load() {
        $this->initialize_settings();
    }

    public function addOptionsPage()
    {
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
    public function enqueScripts($hook)
    {
        if( $hook == 'toplevel_page_safety_exit' ) {
            if (defined('IS_LOCAL') && IS_LOCAL) {
                wp_enqueue_script(
                    'sftExt-admin-admin',
                    'http://localhost:8080/js/admin/master.jsx',
                    [],
                    null,
                    true
                );
            }
            // wp_enqueue_style('sftExt-admin-icon-picker', $this->root . 'assets/css/fontawesome-iconpicker.css');
            // wp_enqueue_style('sftExt-admin-admin', $this->root . 'assets/css/admin.css');
            // wp_enqueue_script('sftExt-admin-color-picker', $this->root . 'assets/vendor/vanilla-picker.min.js');
            // wp_enqueue_script('sftExt-admin-icon-picker-js', $this->root . 'assets/vendor/fontawesome-iconpicker.min.js');
            // wp_register_script('sftExt-admin-js', $this->root . 'assets/js/admin.js', array('jquery', 'sftExt-admin-icon-picker-js', 'sftExt-admin-color-picker'));
            // wp_enqueue_script( 'sftExt-admin-js');

            // // wp_register_script( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/js/all.js' );
            // wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/css/all.css' );

        }
    }

    public function adminInit()
    {

        if(current_user_can('administrator')){

            register_setting( 'pluginPage', 'sftExt_settings' );
            $options = wp_parse_args(get_option('sftExt_settings'), $this->defaults);
            $recClasses = '';
            if(!empty($options['sftExt_type']) && $options['sftExt_type'] == 'rectangle') {
                $recClasses = 'option-wrapper rectangle-only';
            }else{
                $recClasses = 'option-wrapper rectangle-only hidden';
            }
            add_settings_section(
                'sftExt_pluginPage_section',
                __( 'General Settings', 'wordpress' ),
                array( $this, 'settingsSectionCB'),
                'pluginPage',
                array( 'section_id' => 'sftExt_pluginPage_section' )
            );

            // Button position

            add_settings_field(
                'sftExt_position',
                __( 'Button Position', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => 'option-wrapper sftExt_position', 'label_for' => 'sftExt_position' )
            );

            // Button Icon
            add_settings_field(
                'sftExt_fontawesome_icon_classes',
                __( 'Button Icon', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => 'option-wrapper sftExt_fontawesome_icon_classes', 'label_for' => 'sftExt_fontawesome_icon_classes' )
            );

            // End Button Icon

            // Button Color
            add_settings_field(
                'sftExt_bg_color',
                __( 'Button Background Color', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => 'option-wrapper sftExt_bg_color', 'label_for' => 'sftExt_bg_color' )
            );
            // End Button Color
            // Button font Color
            add_settings_field(
                'sftExt_font_color',
                __( 'Button Font/Icon Color', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => 'option-wrapper sftExt_font_color', 'label_for' => 'sftExt_font_color' )
            );
            // End Button font Color

            // Button type

            add_settings_field(
                'sftExt_type',
                __( 'Button Type', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => 'option-wrapper sftExt_type', 'label_for' => 'sftExt_type' )
            );
            add_settings_field(
                'sftExt_border_radius',
                __( 'Border Radius', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => $recClasses, 'label_for' => 'sftExt_border_radius' )
            );
            // Rectangle Settings

            add_settings_field(
                'sftExt_rectangle_text',
                __( 'Button Text', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => $recClasses, 'label_for' => 'sftExt_rectangle_text' )
            );

            add_settings_field(
                'sftExt_rectangle_icon_onOff',
                __( 'Include Icon?', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => $recClasses, 'label_for' => 'sftExt_rectangle_icon_onOff' )
            );
            add_settings_field(
                'sftExt_rectangle_font_size',
                __( 'Font Size', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => $recClasses, 'label_for' => 'sftExt_rectangle_font_size' )
            );
            add_settings_field(
                'sftExt_rectangle_font_size_units',
                __( 'Font Size Units', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_section',
                array ( 'class' => $recClasses, 'label_for' => 'sftExt_rectangle_font_size_units' )
            );

            // End Rectangle Settings

            // Redirect URLs
            add_settings_section(
                'sftExt_pluginPage_redirection_options',
                __( 'Redirection Options', 'wordpress' ),
                array( $this, 'settingsSectionCB'),
                'pluginPage',
                array( 'section_id' => 'sftExt_pluginPage_redirection_options' )
            );

            add_settings_field(
                'sftExt_current_tab_url',
                __( 'Website URL', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_redirection_options',
                array ( 'class' => 'option-wrapper sftExt_current_tab_url', 'label_for' => 'sftExt_current_tab_url' )
            );
            add_settings_field(
                'sftExt_new_tab_url',
                __( 'Website URL', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_redirection_options',
                array ( 'class' => 'option-wrapper sftExt_new_tab_url', 'label_for' => 'sftExt_new_tab_url' )
            );

            // End Button type

            // Button Display Options

            add_settings_section(
                'sftExt_pluginPage_btn_display_options',
                __( 'Button Display Options', 'wordpress' ),
                array( $this, 'settingsSectionCB'),
                'pluginPage',
                array( 'section_id' => 'sftExt_pluginPage_btn_display_options' )
            );
            add_settings_field(
                'sftExt_hide_mobile',
                __( 'Hide button on mobile?', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_btn_display_options',
                array ( 'class' => 'option-wrapper sftExt_hide_mobile', 'label_for' => 'sftExt_hide_mobile' )
            );
            add_settings_field(
                'sftExt_show_all',
                __( 'Show on all pages?', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_btn_display_options',
                array ( 'class' => 'option-wrapper sftExt_show_all', 'label_for' => 'sftExt_show_all' )
            );
            add_settings_field(
                'sftExt_front_page',
                __( 'Show on Front Page?', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_btn_display_options',
                array ( 'class' => 'option-wrapper sftExt_front_page', 'label_for' => 'sftExt_front_page' )
            );
            add_settings_field(
                'sftExt_pages',
                __( 'Select Pages', 'wordpress' ),
                array( $this, 'optionsRenderer'),
                'pluginPage',
                'sftExt_pluginPage_btn_display_options',
                array ( 'class' => 'option-wrapper sftExt_pages', 'label_for' => 'sftExt_pages' )
            );

            // End Button Display Options
        }
	}

    function optionsRenderer( $args )
    {
        $options = wp_parse_args(get_option('sftExt_settings'), $this->defaults);

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
                    <div id="sftExt_icon_display" style="height: 75px;"><i class="fa-3x <?= esc_attr($options['sftExt_fontawesome_icon_classes']); ?>"></i></div>
                    <!-- <button id="sftExt_fontawesome_icon_classes_btn" >Change Icon</button> -->
                    <input type="hidden" id="sftExt_fontawesome_icon_classes" name="sftExt_settings[sftExt_fontawesome_icon_classes]" value="<?= esc_attr( $options['sftExt_fontawesome_icon_classes'] ); ?>">

                <?php
                break;
            case 'sftExt_bg_color':
                ?>
                    <div id="sftExt_color_picker_btn_bg_color" style="background-color: <?= esc_attr( $options['sftExt_bg_color'] )?>">Choose Color</div>
                    <input type="hidden" id="sftExt_bg_color" name="sftExt_settings[sftExt_bg_color]" value="<?= esc_attr( $options['sftExt_bg_color'] ); ?>">

                <?php
                break;
            case 'sftExt_font_color':
                ?>
                    <div id="sftExt_color_picker_btn_font_color" style="background-color: <?= esc_attr( $options['sftExt_font_color'] ); ?>">Choose Color</div>
                    <input type="hidden" id="sftExt_font_color" name="sftExt_settings[sftExt_font_color]" value="<?= esc_attr( $options['sftExt_font_color'] ); ?>">

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
                    <input type="number" id="sftExt_border_radius" name="sftExt_settings[sftExt_border_radius]" value="<?= esc_attr( $options['sftExt_border_radius'] ); ?>"> px
                <?php
                break;
            case 'sftExt_rectangle_font_size':
                ?>
                    <input type="number" id="sftExt_rectangle_font_size" name="sftExt_settings[sftExt_rectangle_font_size]" value="<?= esc_attr( $options['sftExt_rectangle_font_size'] ); ?>"> <span class="sftExt_units"><?= esc_attr( $options['sftExt_rectangle_font_size_units'] ); ?></span>
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
                    <input type="text" id="sftExt_current_tab_url" name="sftExt_settings[sftExt_current_tab_url]" value="<?= esc_attr( $options['sftExt_current_tab_url'] ); ?>">
                <?php
                break;
            case 'sftExt_new_tab_url':
                ?>
                    <input type="text" id="sftExt_new_tab_url" name="sftExt_settings[sftExt_new_tab_url]" value="<?= esc_attr( $options['sftExt_new_tab_url'] ); ?>">
                <?php
                break;
            case 'sftExt_rectangle_text':
                ?>
                    <input type="text" id="sftExt_rectangle_text" name="sftExt_settings[sftExt_rectangle_text]" value="<?= esc_attr( $options['sftExt_rectangle_text'] ); ?>">
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
                    <input type="checkbox" name="sftExt_settings[sftExt_pages][]" id="sftExt_pages" value="<?= $postID; ?>" <?= in_array( $postID, $options['sftExt_pages'] ) ? 'checked="checked"': ''?>> <?= get_the_title( $postID ); ?><br/>
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


    function settingsSectionCB( $args )
    {
        switch($args['id']){
            case 'sftExt_pluginPage_redirection_options':
                echo __( 'Enter the URLs you want the button to redirect to', 'wordpress' );
                break;
        }

    }
}
