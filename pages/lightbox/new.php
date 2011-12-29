<?php
/**
 * Create a new album
 *
 * @package ElggLightbox
 */

//elgg_load_library('elgg:lightbox');

$owner = elgg_get_page_owner_entity();

gatekeeper();
group_gatekeeper();

$title = elgg_echo('photos:add');

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('lightbox'), "photos/all");
if (elgg_instanceof($owner, 'user')) {
	elgg_push_breadcrumb($owner->name, "photos/owner/$owner->username");
} else {
	elgg_push_breadcrumb($owner->name, "photos/group/$owner->guid/all");
}
elgg_push_breadcrumb($title);

// create form
$form_vars = array('enctype' => 'multipart/form-data');
$body_vars = array();
$content = elgg_view_form('lightbox/edit', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
