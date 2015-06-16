/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.toolbar = 'toolbar1';
    config.toolbar_toolbar1 =
    [
	['Source','-','Cut','Copy','Paste','PasteText','PasteFromWord'],
	'/',
	['Print', 'SpellChecker', 'Scayt','-','Undo','Redo','-','Find','Replace','SelectAll','RemoveFormat'],
	'/',
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Link','Unlink','Anchor','-','Bold','Italic','Underline','Strike','-','NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
	'/',
	['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','-','Format','Font','FontSize','-','TextColor','BGColor'],
	'/',
	['Maximize', 'ShowBlocks']
	];
	
	config.toolbar = 'toolbar2';
    config.toolbar_toolbar2 =
    [
	['Source','-','Cut','Copy','Paste','PasteText','PasteFromWord'],
	'/',
	['Undo','Redo','-','Find','Replace','-','Bold','Italic','Underline','Strike','-','SpecialChar'],
	'/',
	['FontSize']
	];	
};
