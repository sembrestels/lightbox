<?php
/**
 * Lightbox helper functions
 *
 * @package ElggLightbox
 */

/**
 * Save uploaded images and return an array of its entities
 *
 * @return array of LightboxPluginImages
 */
function lightbox_get_image_inputs() {
	
	$files = array();
	$file = new ElggFile();
	
	// check if upload failed
	foreach($_FILES as $key => $sent_file) {
		if (empty($sent_file['name'])) {
			continue;
		}
		if($sent_file['error'] != 0) {
			register_error(elgg_echo('file:cannotload'));
			forward(REFERER);
		}
		$mime_type = $file->detectMimeType($sent_file['tmp_name'], $sent_file['type']);
		if(file_get_simple_type($mime_type) != "image"){
			register_error(elgg_echo('lightbox:noimage'));
			forward(REFERER);
		}
	}
	
	foreach($_FILES as $key => $sent_file) {
		
		if (empty($sent_file['name'])) {
			continue;
		}
		
		$file = new ElggFile();
		
		$prefix = "image/";
		$filestorename = elgg_strtolower(time().$sent_file['name']);

		$mime_type = $file->detectMimeType($sent_file['tmp_name'], $sent_file['type']);
		$file->setFilename($prefix . $filestorename);
		$file->setMimeType($mime_type);
		$file->originalfilename = $sent_file['name'];
		$file->simpletype = "image";

		// Open the file to guarantee the directory exists
		$file->open("write");
		$file->close();
		move_uploaded_file($sent_file['tmp_name'], $file->getFilenameOnFilestore());

		$guid = $file->save();

		// We need to create thumbnails (this should be moved into a function)
		if ($guid) {
			$thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),60,60, true);
			if ($thumbnail) {
				$thumb = new ElggFile();
				$thumb->setMimeType($_FILES['upload']['type']);

				$thumb->setFilename($prefix."thumb".$filestorename);
				$thumb->open("write");
				$thumb->write($thumbnail);
				$thumb->close();

				$file->thumbnail = $prefix."thumb".$filestorename;
				unset($thumbnail);
			}

			$thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),153,153, true);
			if ($thumbsmall) {
				$thumb->setFilename($prefix."smallthumb".$filestorename);
				$thumb->open("write");
				$thumb->write($thumbsmall);
				$thumb->close();
				$file->smallthumb = $prefix."smallthumb".$filestorename;
				unset($thumbsmall);
			}

			$thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),600,600, false);
			if ($thumblarge) {
				$thumb->setFilename($prefix."largethumb".$filestorename);
				$thumb->open("write");
				$thumb->write($thumblarge);
				$thumb->close();
				$file->largethumb = $prefix."largethumb".$filestorename;
				unset($thumblarge);
			}
			
			$files[$guid] = $file;
		}
	}
	
	return $files;
}

/**
 * Delete uploaded images if album creation fails
 *
 * @params array  $images Array of LightboxPluginImages
 * @return null
 */
function lightbox_delete_image_inputs($images) {
	//TODO
}
