<?php
/**
 * Album renderer.
 *
 * @package ElggLightbox
 */

$full = elgg_extract('full_view', $vars, FALSE);
$entity = elgg_extract('entity', $vars, FALSE);

if (!$entity) {
	return TRUE;
}

$owner = $entity->getOwnerEntity();
$container = $entity->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = elgg_get_excerpt($entity->description);

$owner_link = elgg_view('output/url', array(
	'href' => "photos/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$icon = elgg_view_entity_icon($entity, 'small');

$tags = elgg_view('output/tags', array('tags' => $entity->tags));
$date = elgg_view_friendly_time($entity->time_created);

$comments_count = $entity->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $entity->getURL() . '#album-comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'album',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full && !elgg_in_context('gallery')) {

	$params = array(
		'entity' => $entity,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	$text = elgg_view('output/longtext', array('value' => $entity->description));
	$body = "$text $extra";

	echo elgg_view('object/elements/full', array(
		'entity' => $entity,
		'title' => false,
		'icon' => $icon,
		'summary' => $summary,
		'body' => $body,
	));

} elseif (elgg_in_context('gallery')) {
	echo '<div class="album-gallery-item">';
	echo "<h3>" . $entity->title . "</h3>";
	echo elgg_view_entity_icon($entity, 'medium');
	echo "<p class='subtitle'>$owner_link $date</p>";
	echo '</div>';
} else {
	// brief view

	$params = array(
		'entity' => $entity,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($icon, $list_body);
}
