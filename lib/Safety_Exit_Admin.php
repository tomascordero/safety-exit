<?php
/**
 * Creates the submenu item for the plugin.
 *
 * @package Custom_Admin_Settings
 */

/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package Custom_Admin_Settings
 */
class Safety_Exit_Admin {

    public function __construct( ) {
    }

    public function init() {
        add_action( 'admin_menu', array( $this, 'safety_exit_add_options_page' ) );
        add_action('admin_init', array( $this, 'plugin_admin_init'));

    }
    public function safety_exit_add_options_page() {

        add_options_page(
            'Safety Exit Settings',
            'Safety Exit Settings',
            'manage_options',
            'safety_exit',
            function(){
                include_once( 'views/plugin-settings.php' );
            }
        );
    }
    public function plugin_admin_init(){
		register_setting( 'pluginPage', 'sftExt_settings' );

        add_settings_section(
            'sftExt_pluginPage_section',
            __( 'Your section description', 'wordpress' ),
            array( $this, 'sftExt_settings_section_callback'),
            'pluginPage'
        );

        add_settings_field(
            'sftExt_select_field_0',
            __( 'Settings field description', 'wordpress' ),
            array( $this, 'sftExt_select_field_0_render'),
            'pluginPage',
            'sftExt_pluginPage_section'
        );
	}
    function sftExt_select_field_0_render(  ) {
        $options = get_option( 'sftExt_settings' );
        ?>
        <select name='sftExt_settings[sftExt_select_field_0]'>
            <option value='bottom-left' <?php selected( $options['sftExt_select_field_0'], 'bottom-left' ); ?>>Bottom Left</option>
            <option value='bottom-right' <?php selected( $options['sftExt_select_field_0'], 'bottom-right' ); ?>>Bottom Right</option>
        </select>

    <?php

    }


    function sftExt_settings_section_callback(  ) {

        echo __( 'This section description', 'wordpress' );

    }
}