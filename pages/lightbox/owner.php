<?php
/**
 * Individual's or group's albums
 *
 * @package ElggLightbox
 */

// access check for closed groups
group_gatekeeper();

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('photos/all');
}

elgg_push_breadcrumb(elgg_echo('lightbox'), "photos/all");
elgg_push_breadcrumb($owner->name);

elgg_register_title_button();

$params = array();

if ($owner->guid == elgg_get_logged_in_user_guid()) {
	// user looking at own albums
	$params['filter_context'] = 'mine';
} else if (elgg_instanceof($owner, 'user')) {
	// someone else's albums
	// do not show select a tab when viewing someone else's posts
	$params['filter_context'] = 'none';
} else {
	// group albums
	$params['filter'] = '';
}

$title = elgg_echo("lightbox:user", array($owner->name));

// List albums
$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => 'album',
	'container_guid' => $owner->guid,
	'limit' => 10,
	'full_view' => FALSE,
));
if (!$content) {
	$content = elgg_echo("lightbox:none");
}

$params['content'] = $content;
$params['title'] = $title;
$params['sidebar'] = elgg_view('lightbox/sidebar');

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
