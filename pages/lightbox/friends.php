<?php
/**
 * Friends albums
 *
 * @package ElggLightbox
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('photos/all');
}

elgg_push_breadcrumb(elgg_echo('lightbox'), "photos/all");
elgg_push_breadcrumb($owner->name, "photos/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo("lightbox:friends");

// offset is grabbed in list_user_friends_objects
$content = list_user_friends_objects($owner->guid, 'albums', 10, false);
if (!$content) {
	$content = elgg_echo("lightbox:none");
}

$body = elgg_view_layout('content', array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
