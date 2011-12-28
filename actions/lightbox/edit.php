<?php
/**
 * Elgg album create/edit action
 *
 * @package ElggLightbox
 */

// Get variables
$title = get_input("title");
$desc = get_input("description");
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$guid = (int) get_input('guid');
$tags = get_input("tags");

if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('lightbox:album');

// check whether this is a new album or an edit
$new_album = true;
if ($guid > 0) {
	$new_album = false;
}

if ($new_album) {

	$album = new ElggObject();
	$album->subtype = "album";

} else {
	// load original album object
	$album = new ElggObject($guid);

	// user must be able to edit album
	if (!$album->guid || !$album->canEdit()) {
		register_error(elgg_echo('lightbox:noaccess'));
		forward(REFERER);
	}

	if (!$title) {
		// user blanked title, but we need one
		$title = $album->title;
	}
}

$album->title = $title;
$album->description = $desc;
$album->access_id = $access_id;
$album->container_guid = $container_guid;
$album->tags = string_to_tag_array($tags);

$guid = $album->save();

// lightbox saved so clear sticky form
elgg_clear_sticky_form('lightbox:album');


// handle results differently for new albums and album updates
if ($new_album) {
	if ($guid) {
		system_message(elgg_echo("lightbox:saved"));
		add_to_river('river/object/album/create', 'create', elgg_get_logged_in_user_guid(), $album->guid);
	} else {
		// failed to save album object - nothing we can do about this
		register_error(elgg_echo("lightbox:save:failed"));
	}

	$container = get_entity($container_guid);
	if (elgg_instanceof($container, 'group')) {
		forward("photos/group/$container->guid/all");
	} else {
		forward("photos/owner/$container->username");
	}

} else {
	if ($guid) {
		system_message(elgg_echo("lightbox:saved"));
	} else {
		register_error(elgg_echo("lightbox:save:failed"));
	}

	forward($album->getURL());
}	
