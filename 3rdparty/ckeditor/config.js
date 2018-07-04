CKEDITOR.editorConfig = function( config )
{
	config.contentsCss = '/style.css';
	config.bodyClass = 'ckeditorBody';
	config.width = '100%';
	config.height = '500px';
	config.language = 'ru';
	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;
	config.docType = '<!DOCTYPE html>';
	config.skin = 'v2';
	config.disableObjectResizing = true;
	config.toolbar_Full =
		[
		    ['Source','-','Maximize','-','Save'],
		    ['SelectAll','Cut','Copy','Paste','PasteText','PasteFromWord'],
		    ['Undo','Redo','Find','Replace'],
		    ['Link','Unlink','Anchor'],
		    ['images','Table','HorizontalRule','SpecialChar'],
		    '/',
		    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		    ['-','Outdent','Indent'],
		    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		    ['TextColor','BGColor','-','sounduk','quotes','dash','jwplayer'],
		    '/',
		    ['Styles','Format','Font','FontSize']
		];
};