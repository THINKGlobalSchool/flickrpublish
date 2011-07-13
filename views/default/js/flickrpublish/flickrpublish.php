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
	$('.tp-publish-flickr img').live('mouseover', elgg.flickrpublish.gallery_show_publish);

	$('.flickr-publish-menu-hover').bind('mouseleave', function() {
		$(this).fadeOut();
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
	$image = $(this);

	var $hovermenu = $(this).data('hovermenu') || null;

	if (!$hovermenu) {
		var $hovermenu = $(this).closest('.tp-publish-flickr').find(".flickr-publish-menu-hover");
		$(this).data('hovermenu', $hovermenu);
	}

	// @todo Use jQuery-ui position library instead -- much simpler
	var offset = $image.offset();
	var top = offset.top + 'px';
	var left = offset.left + 'px';
	var width = ($image.width() - 20) + 'px';
	var height = ($image.height() - 20)  + 'px';

	$hovermenu.appendTo('body')
			.css('position', 'absolute')
			.css("top", top)
			.css("left", left)
			.css("height", height)
			.css("width", width)
			.fadeIn('normal');

	event.stopPropagation();
}

elgg.register_hook_handler('init', 'system', elgg.flickrpublish.init);
//</script>