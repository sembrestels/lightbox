<?php
/**
 * All albums
 *
 * @package ElggLightbox
 */

elgg_push_breadcrumb(elgg_echo('lightbox'));

elgg_register_title_button();

$limit = get_input("limit", 10);

$title = elgg_echo('lightbox:all');

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => 'album',
	'limit' => $limit,
	'full_view' => FALSE,
));
if (!$content) {
	$content = elgg_echo('lightbox:none');
}

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('lightbox/sidebar'),
));

echo elgg_view_page($title, $body);
