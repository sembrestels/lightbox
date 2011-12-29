<?php
/**
 * Elgg image thumbnail
 *
 * @package ElggLightbox
 */

// Get engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Get entity GUID
$guid = (int) get_input('guid', 0);

// Get thumbnail size
$size = get_input('size', 'small');

// Get image or album cover
$entity = new LightboxPluginImage($guid);
if (!$entity->guid) {
	exit;
}


// Get entity thumbnail
switch ($size) {
	case "small":
		$thumb = $entity->thumbnail;
		break;
	case "medium":
		$thumb = $entity->smallthumb;
		break;
	case "large":
	default:
		$thumb = $entity->largethumb;
		break;
}

// Grab the file
if ($thumb && !empty($thumb)) {
	$readfile = new ElggFile();
	$readfile->owner_guid = $entity->owner_guid;
	$readfile->setFilename($thumb);
	$mime = $entity->getMimeType();
	$contents = $readfile->grabFile();

	// caching images for 10 days
	header("Content-type: $mime");
	header('Expires: ' . date('r',time() + 864000));
	header("Pragma: public", true);
	header("Cache-Control: public", true);
	header("Content-Length: " . strlen($contents));

	echo $contents;
	exit;
}
