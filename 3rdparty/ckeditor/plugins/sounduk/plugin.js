CKEDITOR.plugins.add( 'sounduk',
{
	init : function( editor )
	{
		editor.ui.addButton( 'sounduk', { label : 'S°unduk', command : 'sounduk' });
		editor.addCommand('sounduk', { exec: function(editor){ editor.insertText('S°unduk'); } } );

		editor.ui.addButton( 'quotes', { label : '«»', command : 'quotes' });
		editor.addCommand('quotes', { exec:
			function(editor){ var sel = editor.getSelection();
				if (sel!=null && sel.getType() == CKEDITOR.SELECTION_TEXT) var text = sel.getRanges()[0].extractContents().$.textContent;
				if (typeof text=='undefined') text = '';
				editor.insertText('«' + text + '»');
			}});

		editor.ui.addButton('dash', { label : '—', command : 'dash' });
		editor.addCommand('dash', { exec: function(editor){ editor.insertText('—'); } } );

		CKEDITOR.dialog.add('jwplayer', this.path + 'dialogs/jwplayer.js' );		
		editor.addCommand('jwplayer',new CKEDITOR.dialogCommand('jwplayer'));
		editor.ui.addButton( 'jwplayer', { label : 'JWPlayer', command : 'jwplayer' });
	},

	requires : [ 'styles', 'dialog' ]
} );