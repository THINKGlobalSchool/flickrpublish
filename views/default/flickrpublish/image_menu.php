<?php
/**
 * Flickr Publish Image Menu Extender
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

$form = elgg_view('forms/flickrpublish/upload', $vars);

echo <<<HTML
<li id="publish-image"><a class='elgg-lightbox' href="#lightbox-publish">$publish_label</a></li>
<div style="display: none;">
	<div id="lightbox-publish" class="publish-container">
		$form
	</div>
</div>
HTML;
?>