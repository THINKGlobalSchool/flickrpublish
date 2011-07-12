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
elgg_load_js('lightbox');
elgg_load_js('elgg.flickrpublish');

$publish_label = elgg_echo('flickrpublish:label:publishflickr');
$publish_confirm = elgg_echo('flickrpublish:label:confirmpublish');
$publish_submit = elgg_view('input/submit', array(
	'name' => 'publish-flickr-submit',
	'id' => 'publish-flickr-submit',
	'value' => elgg_echo('flickrpublish:label:publish'),
	'class' => 'elgg-button elgg-button-action',
));

$photo_guid = elgg_view('input/hidden', array(
	'name' => 'publish-photo-guid',
	'id' => 'publish-photo-guid',
	'value' => $vars['image_guid'],
));


echo <<<HTML
<li id="publish-image"><a class='elgg-lightbox' href="#lightbox-publish">$publish_label</a></li>
<div style="display: none;">
	<div id="lightbox-publish" class="publish-container">
		<label>$publish_confirm</label><br /><br />
		<center>$publish_submit</center>
		$photo_guid
	</div>
</div>
HTML;
?>