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

	elgg_load_js('lightbox');
	elgg_load_js('elgg.flickrpublish');
	elgg_load_css('elgg.flickrpublish');

	// Register PHPFlickr Library
	elgg_register_library('phpflickr', elgg_get_plugins_path() . 'flickrpublish/vendors/phpFlickr-3.1/phpFlickr.php');
	
	// Hook into tidypics if user can publish
	if (can_flickr_publish()) {
		// Extend image entity menu
		elgg_register_plugin_hook_handler('register', 'menu:entity', 'flickrpublish_photo_menu_handler');

		// Hook into photo summary params handler
		elgg_register_plugin_hook_handler('photo_summary_params', 'tidypics', 'flickrpublish_photo_summary_handler');
	}
	
	// Register actions
	$action_path = elgg_get_plugins_path() . 'flickrpublish/actions/flickrpublish';
	elgg_register_action('flickrpublish/upload', "$action_path/upload.php");
}

/**
 * Hook to customize tidypics photo summary and include flickr publish content
 *
 * @param string $hook   Name of hook
 * @param string $type   Entity type
 * @param mixed  $value  Return value
 * @param array  $params Parameters
 * @return mixed
 */
function flickrpublish_photo_summary_handler($hook, $type, $value, $params) {
	$image = $params['entity'];
	if (elgg_instanceof($image, 'object', 'image') &&  !elgg_in_context('ajaxmodule')) {

		$form = elgg_view('forms/flickrpublish/hover_upload', array('image_guid' => $image->guid));

		$value['class'] .= " tp-publish-flickr";
		$value['footer'] .= "<div class='flickr-publish-menu-hover'>$form</div>";
	}

	return $value;
}

/**
 * Hook to customize tidypics photo entity menu and add flickr publish items
 *
 * @param string $hook   Name of hook
 * @param string $type   Entity type
 * @param mixed  $value  Return value
 * @param array  $params Parameters
 * @return mixed
 */
function flickrpublish_photo_menu_handler($hook, $type, $value, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'image')) {

		$text = elgg_echo('flickrpublish:label:publishflickr');

		$form = elgg_view('forms/flickrpublish/upload', array('image_guid' => $entity->guid));

		$text .= "<div style='display: none;'>
					<div id='lightbox-publish-{$entity->guid}' class='publish-container'>
						$form
					</div>
				</div>";

		$options = array(
			'name' => 'flickrpublish',
			'text' => $text,
			'section' => 'actions',
			'priority' => 900,
			'link_class' => 'flickrpublish-lightbox',
			'href' => '#lightbox-publish-' . $entity->guid,
		);

		$value[] = ElggMenuItem::factory($options);
	}
	return $value;
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
