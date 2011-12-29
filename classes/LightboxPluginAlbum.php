<?php

/**
 * Override the ElggObject
 */
class LightboxPluginAlbum extends ElggObject {
	protected function  initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "album";
	}

	public function __construct($guid = null) {
		parent::__construct($guid);
	}
	
	public function attachImages($images) {
		foreach($images as $image) {
			if($image instanceof LightboxPluginImage) {
				$this->addRelationship($image->guid, 'in_album');
			} else {
				return false;
			}
		}
		return true;
	}

	public function delete() {
		return parent::delete();
	}
}
