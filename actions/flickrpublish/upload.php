<?php
/**
 * Flickr Publish Upload Action
 *
 * @package FlickrPublish
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 */

// Make sure we're allowed to publish
if (!can_flickr_publish()) {
	forward(REFERER);
}

$photo_guid = get_input('photo_guid');

$photo = get_entity($photo_guid);

// Check for proper image
if (!elgg_instanceof($photo, 'object', 'image')) {
	register_error(elgg_echo('flickrpublish:error:invalidphoto'));
	forward(REFERER);
}

// Load in the lib
elgg_load_library('phpflickr');

// New flickr object
$f = new phpFlickr(elgg_get_plugin_setting('apikey', 'flickrpublish'), elgg_get_plugin_setting('appsecret', 'flickrpublish'));

// Set token to our user
$f->setToken(elgg_get_plugin_setting('usertoken', 'flickrpublish'));

// Get tags
$tags = $photo->tags;

if ($tags) {
	if (!is_array($tags)) {
		$tags = array($tags);
	}
} else {
	$tags = array();
}

// Add logged in username as a tag
$tags[] = elgg_get_logged_in_user_entity()->username;

// Need a space seperated string
$tag_string = implode(" ", $tags);



// Try uploading the photo
if ($f->sync_upload($photo->getFilenameOnFileStore(), $photo->title, $photo->description, $tag_string)) {
	// Should have a photo id here
	system_message(elgg_echo('flickrpublish:success:published'));
} else {
	register_error($f->error_msg);
}

forward(REFERER);