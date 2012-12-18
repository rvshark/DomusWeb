/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	//config.skin = 'office2003';
	config.filebrowserBrowseUrl = '../include/ckeditor/kcfinder/browse.php?type=files';	
  config.filebrowserImageBrowseUrl = '../include/ckeditor/kcfinder/browse.php?type=images';
 config.filebrowserFlashBrowseUrl = '../include/ckeditor/kcfinder/browse.php?type=flash';
  config.filebrowserUploadUrl = '../include/ckeditor/kcfinder/upload.php?type=files';
  config.filebrowserImageUploadUrl = '../include/ckeditor/kcfinder/upload.php?type=images';
 config.filebrowserFlashUploadUrl = '../include/ckeditor/kcfinder/upload.php?type=flash';
};
