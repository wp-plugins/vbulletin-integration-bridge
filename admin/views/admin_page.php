<?php
/*
 * @author ObscureCloud
 * @copyright Copyright (C) 2013 ObscureCloud
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
?>
<h2>Settings</h2>
	<div class="wrap">

		<!-- Display Plugin Icon, Header, and Description -->
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Wordpress vBulletin Integration Settings</h2>
		<p>Enter the id of the forum you want your Wordpress posts posted into in vBulletin. The plugin will match the sub forum of this forum with the post category.</p>
		<!-- Beginning of the Plugin Options Form -->
		<form method="post" action="options.php">
			<?php settings_fields('osc_wpvb_plugin_options'); ?>
			<?php $options = get_option('osc_wpvb_options'); ?>
			<table class="form-table">
				<tr>
					<th scope="row">
						Path to vBulletin.
					</th>
					<td>
						<input type="text" size="57" name="osc_wpvb_options[vb_path]" value="<?php echo isset($options['vb_path']) ? $options['vb_path'] : "" ; ?>" />
						<br />
						<span style="color:red">Enter the path relative to your vBulletin installation. Include the trailing slash.</span>
						<br />
						e.g. /foum/
					</td>
				</tr>

				<tr>
					<th scope="row">Activate login sync feature</th>
					<td>
						<label><input name="" type="checkbox" value="1"  disabled="disabled" /> Available with the full version. Visit <a href="http://wp-vb-bridge.obscurecloud.com">WP-vB-Bridge.ObscureCloud.com</a> for more info.</label><br />

					</td>
				</tr>

				<tr>
					<th scope="row">Activate registration sync feature</th>
					<td>
						<label><input name="" type="checkbox" value="1"  disabled="disabled" />  Available with the full version. Visit <a href="http://wp-vb-bridge.obscurecloud.com">WP-vB-Bridge.ObscureCloud.com</a> for more info.</label><br />

					</td>
				</tr>

				<tr>
					<th scope="row">Activate post sync feature</th>
					<td>
						<label><input name="osc_wpvb_options[setting_post_sync]" type="checkbox" value="1" <?php if (isset($options['setting_post_sync'])) { checked('1', $options['setting_post_sync']); } ?> /> Activate</label><br />

					</td>
				</tr>

				<tr>
					<th scope="row">
						vBulletin user id to assign posts to.
					</th>
					<td>
						<input type="text" size="57" name="osc_wpvb_options[vb_post_user]" value="<?php echo isset($options['vb_post_user']) ? $options['vb_post_user'] : "" ; ?>" />
						<br />
						Leave this blank if you want the Wordpress user posting to be used.
						<br />
						<span style="color:red">This will only work if there is a vB user with the same id.</span>
					</td>
				</tr>

				<tr>
					<th scope="row">Activate comment sync feature</th>
					<td>
						<label><input name="" type="checkbox" value="1"  disabled="disabled" />  Available with the full version. Visit <a href="http://wp-vb-bridge.obscurecloud.com">WP-vB-Bridge.ObscureCloud.com</a> for more info.</label><br />

					</td>
				</tr>

				<tr>
					<th scope="row">Activate avatar sync feature</th>
					<td>
						<label><input name="" type="checkbox" value="1"  disabled="disabled" />  Available with the full version. Visit <a href="http://wp-vb-bridge.obscurecloud.com">WP-vB-Bridge.ObscureCloud.com</a> for more info.</label><br />

					</td>
				</tr>

				<tr>
					<th scope="row">
						Forum ID
					</th>
					<td>
						<input type="text" size="57" name="osc_wpvb_options[forum_id]" value="<?php echo isset($options['forum_id']) ? $options['forum_id'] : ""; ?>" />
						<br />
						<span style="color:red">This forum must be set to act like a forum in vBulletin or the post will not show up.</span>
					</td>
				</tr>

				<tr>
					<th scope="row">
						Where to send users upon login.
					</th>
					<td>
						<input type="text" size="57" name="" value="" disabled="disabled" />
						<br />
						<span style="color:red">Enter the path relative to the site root</span>
						<br />
						e.g. "/" for the home page or "/forum"
						<br />
						 Available with the full version. Visit <a href="http://wp-vb-bridge.obscurecloud.com">WP-vB-Bridge.ObscureCloud.com</a> for more info.
					</td>
				</tr>


			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>

	</div>

<hr />

<h2>Sync Wordpress users to the vB database</h2>
<span style="color:red">BACK UP YOUR VBULLETIN DATABASE BEFORE USING THIS OPTION!</span>

<form method="post" action="">
	<input type="hidden" name="form" value="osc_wpvb_db_sync" />
	<input type="submit"  disabled="disabled" />
	 Available with the full version. Visit <a href="http://wp-vb-bridge.obscurecloud.com">WP-vB-Bridge.ObscureCloud.com</a> for more info.
</form>

<hr />