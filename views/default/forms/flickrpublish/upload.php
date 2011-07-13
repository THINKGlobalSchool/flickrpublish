<?php
/**
 * Flickr Publish Form
 *
 * @package FlickrPublish
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 */

$publish_confirm = elgg_echo('flickrpublish:label:confirmpublish');
$publish_submit = elgg_view('input/submit', array(
	'name' => 'publish-flickr-submit',
	'id' => 'publish-flickr-submit',
	'value' => elgg_echo('flickrpublish:label:publish'),
	'class' => 'elgg-button elgg-button-action',
));

$photo_guid = elgg_view('input/hidden', array(
	'name' => 'publish-photo-guid',
	'class' => 'publish-photo-guid',
	'value' => $vars['image_guid'],
));

echo <<<HTML
	<label>$publish_confirm</label><br /><br />
	<center>$publish_submit</center>
	$photo_guid
HTML;
?>