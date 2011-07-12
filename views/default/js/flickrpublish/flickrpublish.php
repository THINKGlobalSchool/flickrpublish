<?php
/**
 * Flickr Publish JS Library
 *
 * @package FlickrPublish
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 */
?>
//<script>
elgg.provide('elgg.flickrpublish');

// Init function
elgg.flickrpublish.init = function() {	
	$('#publish-flickr-submit').live('click', elgg.flickrpublish.publish);
}

/**	
 * Publish the photo to flickr
 */ 
elgg.flickrpublish.publish = function(event) {
	var photo_guid = $('#publish-photo-guid').val();
	var _this = $(this);
	
	$('div.publish-container').addClass('elgg-ajax-loader');
	$('div.publish-container').html("<center><label>" + elgg.echo('flickrpublish:label:uploading') + "</label></center><br /><br /><br /><br <br />")
	
	elgg.action('flickrpublish/upload', {
		data: {
			photo_guid: photo_guid
		},
		success: function(data) {
			if (data.status == -1) {
				$('div.publish-container').removeClass('elgg-ajax-loader');
				$('div.publish-container').html('error: ' + data.system_messages.error);
			} else {
				$('div.publish-container').removeClass('elgg-ajax-loader');
				$('div.publish-container').html('<label>Success!</label>');
			}
		}
	});
	event.preventDefault();
}

elgg.register_hook_handler('init', 'system', elgg.flickrpublish.init);
//</script>