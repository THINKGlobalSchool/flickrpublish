<?php
/**
 * Flickr Publish
 *
 * @package FlickrPublish
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 */

elgg_register_event_handler('init', 'system', 'flickrpublish_init');

function flickrpublish_init() {	
	// Register JS libraries
	$f_js = elgg_get_simplecache_url('js', 'flickrpublish/flickrpublish');
	elgg_register_js('elgg.flickrpublish', $f_js);
	
	// Register PHPFlickr Library
	elgg_register_library('phpflickr', elgg_get_plugins_path() . 'flickrpublish/vendors/phpFlickr-3.1/phpFlickr.php');
	
	// Extend the tidypics image menu
	if (can_flickr_publish()) {
		elgg_extend_view('tidypics/image_menu', 'flickrpublish/image_menu');
	}
	
	// Register actions
	$action_path = elgg_get_plugins_path() . 'flickrpublish/actions/flickrpublish';
	elgg_register_action('flickrpublish/upload', "$action_path/upload.php");
}

/**
 * Helper function to determine if given user
 * can publish to flickr
 * 
 * @param ElggUser $user The user
 * @return bool
 */
function can_flickr_publish($user = NULL) {
	if (elgg_is_admin_logged_in()) {
		return true;
	}
	
	if (!elgg_instanceof($user, 'user')) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	$role = get_entity(elgg_get_plugin_setting('role', 'flickrpublish'));
	
	if (elgg_instanceof($role, 'object', 'role') && $role->isMember($user)) {
		return true;
	} 
	
	return false;
}
