<?php
/*
 * @author ObscureCloud
 * @copyright Copyright (C) 2013 ObscureCloud
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
require_once 'AdminController.php';

class osc_wpvb_AdminMenu extends osc_wpvb_AdminController {
	public $capability = "manage_options";

	function admin_menu() {
		add_options_page( 'Worpress vBuletin integration Lite', 'WP-vB Integration Lite', $this->capability, 'wp-vb', array(&$this, 'settings_page') );
	}

	function settings_page() {
		if ( !current_user_can( $this->capability ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		require_once( OSC_WPVB_PATH . $this->_module_name . "/views/admin_page.php");
	}
}