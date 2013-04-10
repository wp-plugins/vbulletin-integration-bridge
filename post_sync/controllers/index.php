<?php
/*
 * @author ObscureCloud
 * @copyright Copyright (C) 2013 ObscureCloud
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
require_once 'PostSyncController.php';

class osc_wpvb_PostSync extends osc_wpvb_PostSyncController {

	function post_sync($post_id)
	{
		$options = get_option('osc_wpvb_options');
		 if ($options['setting_post_sync'] == "1")
		 {

			global $current_user;
			get_currentuserinfo();

			$vb_files = array("includes/class_dm.php", "includes/class_dm_threadpost.php", "includes/functions_databuild.php");
			$this->_loadVb($vb_files);
			global $vbulletin;

			if ($_POST["hidden_post_status"] != "publish")
			{
				$forum_id = $options['forum_id'];

				if (isset($_POST['post_content'])) $post_text = stripslashes ($_POST['post_content']);
				if (isset($_POST['post_title'])) $title = $_POST['post_title'];

				//get the cat/forum
				foreach ($_POST["post_category"] as $key => $value)
				{
					if ($key != 0)
					{
						$this->_resetWordpressDatabaseConnection();

						$wp_cat = get_category($value);
						$wp_cat_name = $wp_cat->name;

						//vb db
						$vbulletin->db = new vB_Database($vbulletin);
						$vbulletin->db->ping();

						$q = "SELECT forumid FROM " . $vbulletin->db->database . ".forum WHERE `parentlist` LIKE '%{$forum_id},%' AND title = '{$wp_cat_name}'";
						$r = mysql_query($q);
						if ($r && mysql_num_rows($r) > 0)
						{
							$row = mysql_fetch_assoc($r);
							$forum_id = $row["forumid"];
							break;
						}
					}
				}
				//see if one exists already
				$q1 = "SELECT count(threadid) AS count FROM " . $vbulletin->db->database . ".thread WHERE forumid = {$forum_id} AND title = '{$title}';";

				$r1 = mysql_query($q1);

				if($r1)
				{
					$row1 = mysql_fetch_assoc($r1);
					if ((int)$row1["count"] == 0)
					{
						$threaddm = new vB_DataManager_Thread_FirstPost($vbulletin, ERRTYPE_SILENT);
						$post_userid = $options["vb_post_user"] > 0 ? $options["vb_post_user"] : $current_user->ID;
						$vb_user_info = fetch_userinfo($post_userid);
						$user_name = $vb_user_info['username'];
						//@todo: get some error handling here
						//$user_name = $current_user->user_login;
						$allow_smilie = '1';
						$visible = '1';

						$threaddm->do_set('forumid', $forum_id);
						$threaddm->do_set('postuserid', $post_userid);
						$threaddm->do_set('userid', $post_userid);
						$threaddm->do_set('username', $user_name);
						$threaddm->do_set('pagetext', $post_text);
						$threaddm->do_set('title', $title);
						$threaddm->do_set('allowsmilie', $allow_smilie);
						$threaddm->do_set('visible', $visible);

						$vb_thread_id = $threaddm->save();
						build_forum_counters($forum_id);

						//reset the database for wordpress
						$this->_resetWordpressDatabaseConnection();
						//TODO: find out why the wp function addpostmeta doesn't work
						$q2 = "INSERT INTO " . DB_NAME . ".`wp_postmeta` (`post_id`,`meta_key`,`meta_value`) VALUES ({$post_id},'vb_thread_id',{$vb_thread_id});";
						$r2 = mysql_query($q2);

						return;
					}
				}
			}
			//reset the database for wordpress
			$this->_resetWordpressDatabaseConnection();
		 }
	}
}