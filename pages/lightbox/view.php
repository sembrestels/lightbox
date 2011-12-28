<?php
/**
 * View an album or an image
 *
 * @package ElggLightbox
 */

$entity = get_entity(get_input('guid'));

$owner = $entity->getContainerEntity();

elgg_push_breadcrumb(elgg_echo('lightbox'), 'photos/all');

$crumbs_title = $owner->name;
if (elgg_instanceof($owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "photos/group/$owner->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, "photos/owner/$owner->username");
}

$title = $entity->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($entity, array('full_view' => true));
$content .= elgg_view_comments($entity);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
