<?php
/*
 * @author Obscurecloud
 * @copyright Copyright (C) 2013 Obscurecloud
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
define( 'OSC_WPVB_PATH', plugin_dir_path(__FILE__) );
if ( !defined('DS') )
	define('DS', "/");

class osc_wpvb_GlobalController {

	protected $_plugin_name = "wp-vb";

	protected function _resetWordpressDatabaseConnection($close = NULL)
	{
		if ($close)
			mysql_close($close);
		global $wpdb;
		$wpdb->db_connect();
	}

	protected function _generateString($max = 15, $is_salt = true) {
			$characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			if ($is_salt)
			{
				$characterList .= "!@#$%&*?";
			}
			$i = 0;
			$salt = "";
			while ($i < $max) {
				$salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
				$i++;
			}
			return $salt;
	}

	protected function _loadVb($also_load = NULL)
	{
		$options = get_option('osc_wpvb_options');

		define('DIE_QUIETLY', 1);
		define('THIS_SCRIPT', 'vbridge');
		define('NOSHUTDOWNFUNC', true);
		define('LOCATION_BYPASS', 1);
		define('DISABLE_HOOKS', true);
		define('NOCHECKSTATE', true);

               $cwd = getcwd();

		$vb_dir = $_SERVER['DOCUMENT_ROOT'] . $options["vb_path"];

               @chdir($vb_dir);

		include_once('./global.php');
               include_once('./includes/init.php');
		if ($also_load)
		{
			foreach($also_load as $key)
			{
				include_once('./' . $key);
			}
		}

               chdir($cwd);

               define('VB_AREA','Forum');
	}
}