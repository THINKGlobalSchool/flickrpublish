<?php
/**
 * Flickr Publish CSS
 *
 * @package FlickrPublish
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 */
?>

.tp-publish-flickr {
	position: relative;
}

.tp-publish-flickr:hover .flickr-publish-menu-hover {
	display: block;
}


.flickr-publish-menu-hover {
	display: none;
	height: auto;
	z-index: 10000;
	position: absolute;
	top: 0;
	width: 161px;
}


.flickrpublish-hover-container {
	color: #FFF;
}

.flickrpublish-hover-container .publish-container {
	padding-top: 5px;
	padding-bottom: 5px;
	background-color: rgba(0, 0, 0, 0.7);
	margin-left: 4px;
	margin-right: 4px;
	margin-top: 4px;
}

.flickrpublish-hover-container .publish-container.elgg-ajax-loader {
	background-color: #FFFFFF;
}

.flickrpublish-hover-container .publish-container label {
	color: #FFFFFF;
}

#fancybox-wrap {
	z-index: 9002 !important;
}

/** Entity Menu Icon **/
.elgg-menu-item-flickrpublish {
	background: transparent url(<?php echo elgg_get_site_url(); ?>mod/flickrpublish/graphics/f_icon.png) no-repeat left !important;
}
