<?php
/**
 * Flickr Publish Hover Form
 *
 * @package FlickrPublish
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 */

$publish_submit = elgg_view('output/url', array(
	'name' => 'publish-flickr-submit',
	'id' => 'publish-flickr-submit',
	'text' => elgg_echo('flickrpublish:label:publishflickr'),
	'class' => 'elgg-button elgg-button-action',
));

$photo_guid = elgg_view('input/hidden', array(
	'name' => 'publish-photo-guid',
	'class' => 'publish-photo-guid',
	'value' => $vars['image_guid'],
));

echo <<<HTML
	<div class="flickrpublish-hover-container">
		<div class="publish-container">
			<center>
				$publish_submit
			</center>
			$photo_guid
		</div>
	</div>
HTML;
?>