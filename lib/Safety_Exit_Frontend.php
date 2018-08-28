<?php
/**
 * Handle all frontend stuff
 *
 * @package Frontend_stuff
 */

/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package Frontend_stuff
 */
class Safety_Exit_Frontend {

    public function __construct() {
    }

    public function init() {

    }
	function safety_exit_injectTest() {
		include_once( 'views/plugin-settings.php' );
	}
}