<?php
/**
 * Elgg lightbox plugin language pack
 *
 * @package ElggLightbox
 */

$english = array(

	/**
	 * Menu items and titles
	 */
	'lightbox' => "Albums",
	'lightbox:user' => "%s's albums",
	'lightbox:friends' => "Friends' albums",
	'lightbox:all' => "All site albums",
	'lightbox:edit' => "Edit album info",
	'lightbox:more' => "More albums",
	'lightbox:group' => "Group albums",
	'lightbox:num_albums' => "Number of albums to display",
	'lightbox:via' => 'via images',
	'photos:add' => "Create new album",

	'lightbox:title' => "Title",
	'lightbox:description' => "Description",
	'lightbox:tags' => "Tags",
	
	'lightbox:image:upload' => 'Upload and image',
	'lightbox:image:upload:another' => 'Upload another image',
	'lightbox:image:replace' => 'Replace image content (leave blank to not change image)',
	'lightbox:image:title' => 'Title',
	'lightbox:image:description' => 'Description',
	

	'lightbox:widget' => "Albums widget",
	'lightbox:widget:description' => "Showcase your albums",

	'groups:enablelightbox' => 'Enable group albums',

	'lightbox:download' => "Download this",

	'lightbox:delete:confirm' => "Are you sure you want to delete this album and all it's images?",

	'lightbox:display:number' => "Number of albums to display",

	'river:create:object:album' => '%s created the album %s',
	'river:comment:object:album' => '%s commented on the album %s',
	'river:comment:object:image' => '%s commented on the image %s',

	'item:object:image' => 'Images',
	'item:object:album' => 'Image albums',

	/**
	 * Status messages
	 */

		'lightbox:saved' => "Your album was successfully saved.",
		'lightbox:image:saved' => "Your image was successfully saved.",
		
		'lightbox:deleted' => "Your album was successfully deleted.",
		'lightbox:image:deleted' => "This image was successfully deleted.",
		

	/**
	 * Error messages
	 */

		'lightbox:none' => "No albums.",
		'lightbox:image:none' => "No images on this album.",
		'lightbox:save:failed' => "Sorry; we could not save your album.",
		'lightbox:delete:failed' => "Your album could not be deleted at this time.",
		'lightbox:noaccess' => "You do not have permissions to change this album",
		'lightbox:nofile' => "You must select an image",
);

add_translation("en", $english);
