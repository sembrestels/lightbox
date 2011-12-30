<?php
/**
 * Display an image
 */

$image_url = elgg_get_site_url() . "mod/lightbox/thumbnail.php?guid={$vars['entity']->getGUID()}&size=large";
$image_url = elgg_format_url($image_url);
$download_url = elgg_get_site_url() . "mod/lightbox/thumbnail.php?guid={$vars['entity']->getGUID()}&size=full";

if ($vars['full_view'] && $smallthumb = $vars['entity']->smallthumb) {
	echo <<<HTML
		<div class="file-photo">
			<a href="$download_url"><img class="elgg-photo" src="$image_url" /></a>
		</div>
HTML;
}
