<?php
/**
 * Flickr Publish Settings
 *
 * @package FlickrPublish
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 */

$roles = get_roles(0);

$roles_options = array();

foreach($roles as $role) {
	$roles_options[$role->guid] = $role->title;
}
?>
<br />
<div>
	<label>IMPORTANT!</label><br />
	Elgg data directory permissions <strong>MUST</strong> be kosher before this plugin will work.
	If cURL can't access the file on the disk, it can't upload it to Flickr!!
</div>
<br />
<div>
	<label><?php echo elgg_echo('flickrpublish:label:apikey'); ?></label><br />
	<?php 
	echo elgg_view('input/text', array(
		'name' => 'params[apikey]', 
		'value' => $vars['entity']->apikey
	)); 
	?>
</div>
<div>
	<label><?php echo elgg_echo('flickrpublish:label:appsecret'); ?></label><br />
	<?php 
	echo elgg_view('input/text', array(
		'name' => 'params[appsecret]', 
		'value' => $vars['entity']->appsecret
	)); 
	?>
</div>
<div>
	<label><?php echo elgg_echo('flickrpublish:label:usertoken'); ?></label><br />
	<strong>Note:</strong>
	See http://phpflickr.com/docs/flickr-authentication/ regarding authentication. We need to generate a token 
	that is associated with a specific user (that has allowed this app to access its data)<br />
	<?php 
	echo elgg_view('input/text', array(
		'name' => 'params[usertoken]', 
		'value' => $vars['entity']->usertoken
	)); 
	?>
</div>
<div>
	<label><?php echo elgg_echo('flickrpublish:label:role'); ?></label><br />
	<?php 
 	echo elgg_view('input/dropdown', array(
		'name' => 'params[role]',
		'options_values' => $roles_options,
		'value' => $vars['entity']->role,
	));
	?>
</div>