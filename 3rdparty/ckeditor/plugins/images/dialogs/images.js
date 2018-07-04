CKEDITOR.dialog.add( 'images', function(editor){

	var dlg;
	
	var width = '', height = '', origWidth = '', origHeight = '', ratio = 1;
	
	var html =
		'<div id="i_status" style="margin:0 0 10px 0; text-align: center;">&nbsp;</div>'+
		'<div style="margin-bottom:10px">Путь к изображению: '+
		'<input type="text" value="" id="i_src" style="width:290px"/></div>'+
		'<form action="/upload.php" method="POST" enctype="multipart/form-data" target="i_frame" id="i_form" style="margin-bottom:15px">'+
		'Загрузка файла: <span><input type="file" value="" id="i_file" name="i_file"/></span>'+
		'<input type="submit" value="Загрузить"/>'+
		'<input type="hidden" name="path" value="'+ckeUploadPath+'"></form><iframe name="i_frame" id="i_frame" src="about:blank" style="display:none"></iframe>'+
		'<div style="border-top:1px solid #CCC; padding-top:10px">'+
		'<table width="100%" class="pd73">'+
		'<tr><td>Альтернативный текст:</td><td><input type="text" value="" id="i_alt" style="width:180px;margin-right:30px"/>'+
		'<label><input type="checkbox" id="i_border"> рамка</label></td>'+
		'</tr><tr><td>Расположение:</td><td>'+
		'<label><input type="radio" value="left" id="i_fleft" name="i_float"/> слева от текста</label>'+
		'<label><input type="radio" value="right" id="i_fright" name="i_float"/> справа от текста</label>'+
		'<label><input type="radio" value="none" id="i_fnone" name="i_float"/> в строке</label>'+    
		'</td></tr><tr><td>Размер:</td>'+
		'<td><input type="text" id="i_width" style="width:30px" value=""/> x <input type="text" style="width:30px" id="i_height" value=""/>&nbsp;&nbsp;&nbsp;'+
		'<label><input type="checkbox" id="i_thumb"> добавить ссылку на оригинал</label>'+
		'</td>'+
		'</tr></table></div>';
		
	var onUpload = function(ev){
		var doc = typeof this.contentDocument == 'undefined' ?
				  document.frames[this.getAttribute('name')].document :
					  this.contentDocument;
		if (doc.location.href=='about:blank') return;
		var reply = doc.body.innerHTML;
		try {
			eval('var result = ' + reply);
		} catch (e){ $('#i_status').html('Ошибка загрузки файла! ' + reply); return; };
		if (result.status=='ok') {
			var uf = $('#__uploaded_files');
			if (uf.length) uf.val(uf.val()+','+result.file);
			$('#i_src').val(result.file);
			$('#i_status').html('<span style="color:green; font-weight:bold">Файл ' + result.filename + ' успешно загружен (' + result.size + ' байт)</span>');
			if (result.width && result.height){
				dlg.width = dlg.origWidth = result.width;
				dlg.height = dlg.origHeight = result.height;
				dlg.ratio = dlg.width / dlg.height;
				$('#i_width').val(result.width);
				$('#i_height').val(result.height);
			}
		} else $('#i_status').html('Ошибка: ' + result.error);
	};
	
	var onWidthChange = function(ev){
		w = parseInt(this.value);
		if (w!=this.value) this.value = dlg.width;
		dlg.width = w;
		$('#i_height').val(dlg.height = Math.round(w/dlg.ratio));
	};
	
	var onHeightChange = function(ev){
		h = parseInt(this.value);
		if (h!=this.value) this.value = dlg.height;
		dlg.height = h;
		$('#i_width').val(dlg.width = Math.round(h*dlg.ratio));
	};
	
	var onOk = function(){
		var src = $('#i_src').val();
		var w = this.width;
		var h = this.height;
		if (!src){
			alert('Не введён адрес изображения');
			return false;
		}
		if (!w || !h){
			alert('Необходимо задать размеры изображения');
			return false;
		}
		
		var insert = false;
		if (this.image==null){
			this.image = editor.document.createElement('img');
			insert = true;
		}
		
		this.image.setAttribute('alt', $('#i_alt').val());
		
		this.image.setAttribute('src', $('#i_src').val());
		this.image.setAttribute('_cke_saved_src', $('#i_src').val());
		this.image.setAttribute('i_width', this.origWidth);
		this.image.setAttribute('i_height', this.origHeight);
		
		this.image.setStyle('width', w + 'px');
		this.image.setStyle('height', h + 'px');
		
		if ($('#i_border').attr('checked')) this.image.addClass('frame'); else this.image.removeClass('frame');
		
		var float = $('input[name=i_float]:checked').val();
		if (float=='left') this.image.addClass('fleft'); else this.image.removeClass('fleft');
		if (float=='right') this.image.addClass('fright'); else this.image.removeClass('fright');
		
		if ($('#i_thumb').attr('checked')) this.image.setAttribute('i_thumb', 1); else this.image.removeAttribute('i_thumb');
		
		if (insert) editor.insertElement(this.image);
	};
	
	var onShow = function(){
		var editor = this.getParentEditor();
		var sel = editor.getSelection();
		var element = sel.getSelectedElement();

		dlg = this;
		
		if (element && element.getName()=='img' && !element.getAttribute('_cke_realelement')){
			this.image = element;
			$('#i_src').val(this.image.getAttribute('src'));
			$('#i_alt').val(this.image.getAttribute('alt'));
			$('#i_border').attr('checked', this.image.hasClass('frame'));
			$('#i_fnone').attr('checked', true);
			$('#i_fleft').attr('checked', this.image.hasClass('fleft'));
			$('#i_fright').attr('checked', this.image.hasClass('fright'));
			$('#i_thumb').attr('checked', this.image.hasAttribute('i_thumb'));
			var img = $(this.image.$);
			this.width = parseInt(this.image.getStyle('width'));
			if (!this.width) this.width = img.width();
			this.height = parseInt(this.image.getStyle('height'));
			if (!this.height) this.height = img.height();
			this.origWidth = this.image.getAttribute('i_width');
			if (!this.origWidth) this.origWidth = this.width;
			this.origHeight = this.image.getAttribute('i_height');
			if (!this.origHeight) this.origHeight = this.height;
			this.ratio = this.origWidth / this.origHeight;
			$('#i_width').val(this.width);
			$('#i_height').val(this.height);
		} else {
			this.image = null;
			width = height = origWidth = origHeight = '';
			$('#i_status').html('&nbsp;');
			$('#i_src').val('');
			$('#i_alt').val('');
			$('#i_fnone').attr('checked', true);
			$('#i_border').attr('checked', true);
			$('#i_thumb').attr('checked', false);
		}
		$('#i_file').parent().html('<input type="file" value="" id="i_file" name="i_file"/>');
	};
	
	var cont =  {
    				type : 'html',
    				html : html,
    				onLoad : function(event){
						$('#i_frame').load(onUpload);
						$('#i_form').submit(function(ev){ $('#i_status').html('<img src="/img/ajax.gif" style="vertical-align:middle"> Загрузка...'); });
						$('#i_width').change(onWidthChange).keyup(onWidthChange);
						$('#i_height').change(onHeightChange).keyup(onHeightChange);
					},
    				style : 'display: block; width: 100%'
				};
	
	return {
		title : 'Изображение',
		minWidth : 420,
		minHeight : 230,
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
        onShow : onShow,
		buttons : [ CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton ]
	};
	
});