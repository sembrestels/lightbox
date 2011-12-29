<?php
/**
 * Elgg lightbox plugin
 *
 * @package ElggLightbox
 */

elgg_register_event_handler('init', 'system', 'lightbox_init');

/**
 * Initialize the lightbox plugin.
 */
function lightbox_init() {

	elgg_register_library('elgg:lightbox', elgg_get_plugins_path() . 'lightbox/lib/lightbox.php');

	// register group entities for search
	elgg_register_entity_type('object', 'image', 'LightboxPluginImage');
	elgg_register_entity_type('object', 'album', 'LightboxPluginAlbum');

	// Set up the menu
	$item = new ElggMenuItem('lightbox', elgg_echo('lightbox'), 'photos/all');
	elgg_register_menu_item('site', $item);

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('photos', 'lightbox_page_handler');

	// Register URL handlers for groups
	elgg_register_entity_url_handler('object', 'image', 'lightbox_url');
	elgg_register_entity_url_handler('object', 'album', 'lightbox_url');
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'lightbox_icon_url_override');

	// Register some actions
	$action_base = elgg_get_plugins_path() . 'lightbox/actions/lightbox';
	elgg_register_action("lightbox/edit", "$action_base/edit.php");
	elgg_register_action("lightbox/delete", "$action_base/delete.php");
	
	$action_base .= '/images';
	elgg_register_action("lightbox/albums/edit", "$action_base/edit.php");
	elgg_register_action("lightbox/albums/delete", "$action_base/delete.php");

	// Add some widgets
	elgg_register_widget_type('lightbox', elgg_echo('lightbox:widget'), elgg_echo('groups:widgets:description'));

	// add group photos tool option
	add_group_tool_option('lightbox', elgg_echo('groups:enablelightbox'), true);
	elgg_extend_view('groups/tool_latest', 'groups/profile/lightbox_module');

	// add link to owner block
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'lightbox_owner_block_menu');

	// photo and album entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'lightbox_entity_menu_setup');

	//extend some views
	elgg_extend_view('css/elgg', 'lightbox/css');
	elgg_extend_view('js/elgg', 'lightbox/js');

}

/**
 * Dispatches photo and album pages.
 * URLs take the form of
 *  All albums:      photos/all
 *  User's albums:   photos/owner/<username>
 *  Friends' albums: photos/friends/<username>
 *  View album:      photos/album/<guid>/<title>
 *  View photo:      photos/view/<guid>/<title>
 *  New album:       photos/add/<guid>
 *  Edit album:      photos/edit/<guid>
 *  Group albums:    photos/group/<guid>/all
 *  Download:        photos/download/<guid>
 *
 * Title is ignored
 *
 * @param array $page
 * @return bool
 */
function lightbox_page_handler($page) {

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$pages_dir = elgg_get_plugins_path() . 'lightbox/pages/lightbox';

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			include "$pages_dir/owner.php";
			break;
		case 'friends':
			include "$pages_dir/friends.php";
			break;
		case 'album':
		case 'view':
			set_input('guid', $page[1]);
			include "$pages_dir/view.php";
			break;
		case 'add':
			include "$pages_dir/new.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$pages_dir/edit.php";
			break;
		case 'group':
			include "$pages_dir/owner.php";
			break;
		case 'all':
			include "$pages_dir/world.php";
			break;
		case 'download':
			set_input('guid', $page[1]);
			include "$pages_dir/download.php";
			break;
		default:
			return false;
	}
	return true;
}

/**
 * Populates the ->getUrl() method for photo and album objects
 *
 * @param ElggEntity $entity Photo or album entity
 * @return string Photo or album URL
 */
function lightbox_url($entity) {
	$title = elgg_get_friendly_title($entity->name);

	if($entity->getSubtype() == 'album') {	
		return "photos/album/{$entity->guid}/$title";
	} else {
		return "photos/view/{$entity->guid}/$title";
	}
}

/**
 * Override the default entity icon for photos and albums
 *
 * @return string Relative URL
 */
function lightbox_icon_url_override($hook, $type, $returnvalue, $params) {
	// TODO
	$entity = $params['entity'];
	$size = $params['size'];

	if (isset($entity->thumbnail)) {
		// return thumbnail
		return "";
	}

	return "mod/lightbox/graphics/default{$size}.gif";
}

/**
 * Add a menu item to the user ownerblock
 */
function lightbox_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "photos/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('lightbox', elgg_echo('lightbox'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->lightbox_enable != "no") {
			$url = "photos/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('lightbox', elgg_echo('lightbox:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add links/info to entity menu particular to group entities
 */
function lightbox_entity_menu_setup($hook, $type, $return, $params) {
	return $return;
}
