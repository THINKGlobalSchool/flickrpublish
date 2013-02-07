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
	$(document).delegate('#publish-flickr-submit', 'click', elgg.flickrpublish.publish);
}

/**	
 * Publish the photo to flickr
 */ 
elgg.flickrpublish.publish = function(event) {
	var _this = $(this);
	var container = _this.closest('.publish-container');
	var photo_guid = container.find('.publish-photo-guid').val();
	
	container.addClass('elgg-ajax-loader');
	container.html("<span>&nbsp;</span>");
	
	elgg.action('flickrpublish/upload', {
		data: {
			photo_guid: photo_guid
		},
		success: function(data) {
			if (data.status == -1) {
				container.removeClass('elgg-ajax-loader');
				container.html('error: ' + data.system_messages.error);
				// Log further error data
				console.log(data);
			} else {
				container.removeClass('elgg-ajax-loader');
				container.html('<center><label>Success!</label></center>');
			}
		}
	});
	event.preventDefault();
}

// initialize flickrpublish lightboxes
elgg.flickrpublish.init_lightbox = function() {
	$(".flickrpublish-lightbox").fancybox({
		'onClosed' : function() {
			// Re-bind tidypics fancybox events
			$.fancybox2.bindEvents();
		}
	});
}

elgg.register_hook_handler('init', 'system', elgg.flickrpublish.init);
elgg.register_hook_handler('photoLightboxAfterShow', 'tidypics', elgg.flickrpublish.init_lightbox);