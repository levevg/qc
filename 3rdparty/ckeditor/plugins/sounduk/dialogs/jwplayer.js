CKEDITOR.dialog.add( 'jwplayer', function(editor){

	var dialog;
	
	var html = 'Ссылка на медиа-файл (mp3 или flv) : <br />' +
			   '<input type="text" value="/" id="media_file" style="width:100%" />' +
			   '' +
			   '';
	
	var onOk = function(){
		var src = $('#media_file').val();
		var type = null;
		if (/\.mp3$/.exec(src)) type = 'audio';
		if (/\.flv$/.exec(src)) type = 'video';
		if (type){
			editor.insertHtml('<input type="button" value="' + src + '" class="jwplayer_' + type + '" /><br />' );
			return true;
		} else {
			alert('Допустимые расширения файлов: mp3, flv');
			return false;
		}
	};
	
	var cont = {
    		type : 'html',
    		html : html,
    		onLoad : function(event){ dialog = event.sender; },
    		style : 'display: block; width: 100%'
	};
	
	return {
		title : 'Вставка плеера',
		minWidth : 300,
		minHeight : 70,
		contents : [
			{
				id : 'jwtab1',
				label : '',
				title : '',
				expand : true,
				padding : 0,
				elements : [ cont ]
			}
		],
        onOk : onOk,
		buttons : [ CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton ]
	};
	
});