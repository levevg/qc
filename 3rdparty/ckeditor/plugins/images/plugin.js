CKEDITOR.plugins.add( 'images',
{
	init : function( editor )
	{
		CKEDITOR.dialog.add('images', this.path + 'dialogs/images.js' );		
		editor.addCommand('images', new CKEDITOR.dialogCommand('images'));
		editor.ui.addButton( 'images', { label : 'Изображение', command : 'images' });
	}

});