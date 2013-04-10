<?php
/*
Plugin Name: Wordpress vBulletin Integration Lite
Plugin URI: http://wordpress-vbulletin.com
Description: Integrate Wordpress and vBulletin installations
Version: 1.0
Author:Don Rzeszut
Author URI:http://wordpress-vbulletin.com
License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 * @copyright Copyright (C) 2013 Obscurecloud
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */


/**
 * admin_init
 */
add_action('admin_init', 'osc_wpvb_init' );

function osc_wpvb_init(){
	register_setting( 'osc_wpvb_plugin_options', 'osc_wpvb_options', 'osc_wpvb_validate_options' );
}
function osc_wpvb_validate_options($input) {
	 // strip html from textboxes
	$input['txt_one'] =  wp_filter_nohtml_kses($input['forum_id']); // Sanitize textbox input (strip html tags, and escape characters)
	return $input;
}

/**
 * adds the admin menu item
 */
add_action('admin_menu', 'osc_wpvb_admin_menu');

function osc_wpvb_admin_menu() {
	include_once( dirname(__FILE__) . '/admin/controllers/index.php');
	$class = new osc_wpvb_AdminMenu();
	$class->admin_menu();
}

/**
 * adds the new post hook
 */
add_action('publish_post', 'osc_wpvb_sync_post');

function osc_wpvb_sync_post($post_id) {
		include_once( dirname(__FILE__) . '/post_sync/controllers/index.php');
		$class = new osc_wpvb_PostSync();
		$class->post_sync($post_id);
}