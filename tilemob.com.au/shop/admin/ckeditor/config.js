/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config ) {
	config.filebrowserBrowseUrl = 'ckeditor/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = 'ckeditor/kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl = 'ckeditor/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl = 'ckeditor/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = 'ckeditor/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = 'ckeditor/kcfinder/upload.php?type=flash';
	config.resize_enabled = false;
	config.toolbarCanCollapse = false;
	config.toolbar = 'toolbar1';
    config.toolbar_toolbar1 =
    [
	['Source','-','Cut','Copy','Paste','PasteText','PasteFromWord'],
	'/',
	['Print', 'SpellChecker', 'Scayt','-','Undo','Redo','-','Find','Replace','SelectAll','RemoveFormat'],
	'/',
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Link','Unlink','Anchor','-','Bold','Italic','Underline','Strike','-','NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
	'/',
	['Image','Flash','Table','HorizontalRule','SpecialChar','-','Format','Font','FontSize','-','TextColor','BGColor']
	];
	
	config.toolbar = 'toolbar2';
    config.toolbar_toolbar2 =
    [
	['Source','-','Undo','Redo','-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Find','Replace','-','Bold','Italic','Underline','Strike'],
	'/',
	['RemoveFormat','-','NumberedList','BulletedList','-','Outdent','Indent','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Link','Unlink','Anchor','-','Image','Flash'],
	'/',
	['Table','HorizontalRule','-','SpecialChar','-','TextColor','BGColor','-','Format','Font','FontSize']
	];
	
	config.toolbar = 'toolbar3';
    config.toolbar_toolbar3 =
    [
	['Source','-','Cut','Copy','Paste','PasteText','PasteFromWord'],
	'/',
	['Undo','Redo','-','Find','Replace','SelectAll','RemoveFormat'],
	'/',
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Link','Unlink','Anchor','-','Bold','Italic','Underline','Strike','-','NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
	'/',
	['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','-','TextColor','BGColor'],
	'/',
	['Format','Font','FontSize']
	];
};