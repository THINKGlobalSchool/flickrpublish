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

	// Show/Hide hover menu
	$('.tp-publish-flickr').hover(elgg.flickrpublish.gallery_show_publish, function() {
			var $hovermenu = $(this).find('img').data('hovermenu');
			if ($hovermenu) {
				$hovermenu.fadeOut();
			}		
	});

	// Fix for hover menu when lighbox link is clicked
	$('.tp-publish-flickr a.tidypics-lightbox').live('click', function() {
		$('.flickr-publish-menu-hover').fadeOut();
	});
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

/**
 * Show the publish hover in tidypics gallery mode
 */
elgg.flickrpublish.gallery_show_publish = function(event) {
	$image = $(this).find('img');

	var $hovermenu = $image.data('hovermenu') || null;

	if (!$hovermenu) {
		var $hovermenu = $image.closest('.tp-publish-flickr').find(".flickr-publish-menu-hover");
		$image.data('hovermenu', $hovermenu);
	}

	$hovermenu.css("width", $image.width() + 'px').fadeIn('fast').position({
		my: "left top",
		at: "left top",
		of: $image
	}).appendTo($image.closest('.tp-publish-flickr'));
}

elgg.register_hook_handler('init', 'system', elgg.flickrpublish.init);