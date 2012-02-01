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
	elgg_register_simplecache_view('js/flickrpublish/flickrpublish');
	elgg_register_js('elgg.flickrpublish', $f_js);
	
	// Register CSS
	$f_css = elgg_get_simplecache_url('css', 'flickrpublish/css');
	elgg_register_simplecache_view('css/flickrpublish/css');
	elgg_register_css('elgg.flickrpublish', $f_css);

	// Register PHPFlickr Library
	elgg_register_library('phpflickr', elgg_get_plugins_path() . 'flickrpublish/vendors/phpFlickr-3.1/phpFlickr.php');
	
	// Hook into tidypics if user can publish
	if (can_flickr_publish()) {
		// Extend image menu
		elgg_extend_view('tidypics/image_menu', 'flickrpublish/image_menu');

		// Hook into image thumbnail view
		elgg_register_plugin_hook_handler('tp_thumbnail_link', 'album', 'flickrpublish_thumbnail_handler');
	}
	
	// Register actions
	$action_path = elgg_get_plugins_path() . 'flickrpublish/actions/flickrpublish';
	elgg_register_action('flickrpublish/upload', "$action_path/upload.php");
}

/**
 * Hook to customize tidypics image thumbnail display
 *
 * @param string $hook   Name of hook
 * @param string $type   Entity type
 * @param mixed  $value  Return value
 * @param array  $params Parameters
 * @return mixed
 */
function flickrpublish_thumbnail_handler($hook, $type, $value, $params) {
	$image = $params['image'];
	if (elgg_instanceof($image, 'object', 'image') &&  !elgg_in_context('ajaxmodule')) {
		elgg_load_js('lightbox');
		elgg_load_js('elgg.flickrpublish');
		elgg_load_css('elgg.flickrpublish');

		$url = elgg_get_site_url();

		$form = elgg_view('forms/flickrpublish/hover_upload', array('image_guid' => $image->guid));
		
		$lightbox_url = elgg_get_site_url() . 'ajax/view/tidypics/image_lightbox?guid=' . $image->guid;
		
		// @TODO this should change to be a plugin hook since I'm controlling our tidypics code
		$value = "<div class='tidypics_album_images tp-publish-flickr'>
					<a class='tidypics-lightbox' href='{$lightbox_url}'><img id='{$image->guid}' src='{$url}photos/thumbnail/{$image->guid}/small/' alt='{$image->title}' /></a>
					<div class='flickr-publish-menu-hover'>$form</div>
				</div>";

		return $value;
	} else {
		return FALSE;
	}
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
