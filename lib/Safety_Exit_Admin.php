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
        add_action( 'admin_head-nav-menus.php', array( $this, 'my_register_menu_metabox'), 10, 1  );
        // add_action( 'update_option_sftExt_settings', array($this, 'sftExt_generateCSS') );
    }
    public function my_register_menu_metabox(  ) {
        $custom_param = array( 0 => 'This param will be passed to my_render_menu_metabox' );

	    add_meta_box(
            'my-menu-test-metabox',
            'Safety Exit Button',
            array( $this, 'my_render_menu_metabox'),
            'nav-menus',
            'side',
            'default',
            $custom_param );
    }
    public function my_render_menu_metabox( $object, $args ) {
        global $nav_menu_selected_id;
        // Create an array of objects that imitate Post objects
        $my_items = array(
            (object) array(
                'ID' => 1,
                'db_id' => 0,
                'menu_item_parent' => 0,
                'object_id' => 1,
                'post_parent' => 0,
                'type' => 'test',
                'object' => 'safety-exit',
                'type_label' => 'My Cool Plugin',
                'title' => 'Exit Button',
                'url' => '#',
                'target' => '',
                'attr_title' => 'test',
                'description' => '',
                'classes' => array(),
                'xfn' => '',
            ),
        );
        $db_fields = false;
        // If your links will be hieararchical, adjust the $db_fields array bellow
        if ( false ) {
            $db_fields = array( 'parent' => 'parent', 'id' => 'post_parent' );
        }
        $walker = new Walker_Nav_Menu_Checklist( $db_fields );
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        ); ?>
        <div id="my-plugin-div">
            <div id="tabs-panel-my-plugin-all" class="tabs-panel tabs-panel-active">
            <ul id="my-plugin-checklist-pop" class="categorychecklist form-no-clear" >
                <?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $my_items ), 0, (object) array( 'walker' => $walker ) ); ?>
            </ul>

            <p class="button-controls">


                <span class="add-to-menu">
                    <input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-my-plugin-menu-item" id="submit-my-plugin-div" />
                    <span class="spinner"></span>
                </span>
            </p>
        </div>
        <?php
    }
    public function sftExt_generateCSS() {
        // die;
        $options = wp_parse_args(get_option('sftExt_settings'), $this->defaults);
        $cssString = '#sftExt-frontend-button.rectangle{font-size: '. $options['sftExt_rectangle_font_size'] . $options['sftExt_rectangle_font_size_units'] . ';}' ;
        wp_parse_args(update_option('sftExt_settings'), array(
            'sftExt_css' => $cssString
        ));
        // update_option('sftExt_css', $cssString);
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
    public function plugin_admin_enqueue_scripts($hook){
        // echo $hook;die;
        if( $hook == 'settings_page_safety_exit' ) {

            wp_register_script('sftExt-admin-js', $this->root . 'assets/js/admin.js', array('jquery'));
            wp_enqueue_script( 'sftExt-admin-js');
            wp_enqueue_style('sftExt-admin-icon-picker', $this->root . 'assets/css/fontawesome-iconpicker.css');
            wp_enqueue_script('sftExt-admin-icon-picker-js', $this->root . 'assets/js/fontawesome-iconpicker.min.js');

            // wp_register_script( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/js/all.js' );
            wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.1/css/all.css' );

        }
    }
    private $defaults = array(
        'sftExt_position' => 'bottom right',
        'sftExt_fontawesome_icon_classes' => 'fas fa-times',
        'sftExt_type' => 'rectangle',
        'sftExt_current_tab_url' => 'https://google.com',
        'sftExt_new_tab_url' => 'https://google.com',
        'sftExt_rectangle_text' => 'Safety Exit',
        'sftExt_rectangle_icon_onOff' => 'yes',
        'sftExt_rectangle_font_size_units' => 'em',
        'sftExt_rectangle_font_size' => '20'
    );
    public function plugin_admin_init(){


		register_setting( 'pluginPage', 'sftExt_settings' );
        $options = wp_parse_args(get_option('sftExt_settings'), $this->defaults);
        $recClasses;
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
        // Button type

        add_settings_field(
            'sftExt_type',
            __( 'Button Type', 'wordpress' ),
            array( $this, 'sftExt_options_render'),
            'pluginPage',
            'sftExt_pluginPage_section',
            array ( 'class' => 'option-wrapper sftExt_type', 'label_for' => 'sftExt_type' )
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
	}

    function sftExt_options_render( $args ) {
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
                    <div id="sftExt_icon_display" style="height: 75px;"><i class="fa-3x <?= $options['sftExt_fontawesome_icon_classes']; ?>"></i></div>
                    <!-- <button id="sftExt_fontawesome_icon_classes_btn" >Change Icon</button> -->
                    <input type="hidden" id="sftExt_fontawesome_icon_classes" name="sftExt_settings[sftExt_fontawesome_icon_classes]" value="<?= $options['sftExt_fontawesome_icon_classes']; ?>">

                <?php
                break;
            case 'sftExt_type':

                echo $options['sftExt_css'];
                ?>
                    <select id="sftExt_type" name='sftExt_settings[sftExt_type]'>
                        <option value='round' <?php selected( $options['sftExt_type'], 'round' ); ?>>Round</option>
                        <option value='rectangle' <?php selected( $options['sftExt_type'], 'rectangle' ); ?>>Rectangle</option>
                    </select>
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