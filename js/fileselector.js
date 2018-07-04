$.prototype.fileSelector = function(options){

	var root = '/';
	var filter = /./;
	var input = this;
	var drop = null;
	var list = [];
	var list_path = null;
	var loading = 0;
	
	function showDefault(){
		var val = input.val();
		if (val=='' || val==root || val==root+'...'){
			input.val(root + '...').addClass('default_path');
		} else input.removeClass('default_path');
	}
	
	function setLoading(d){
		loading += d;
		if (loading>0) drop.addClass('loading');
		else drop.removeClass('loading');
	}
	
	function updateList(){
		var val = input.val();
		if (list_path===val) return true;
		setLoading(1);
		$.ajax({
			url: '/fileselector.php',
			data: {path: val, filter: filter},
			success: function(result){
				list_path = result.path;
				list = result.list;
				setTimeout(updateDropdown, 50);
			},
			complete: function(s){
				setLoading(-1);
			}
		});
		return false;
	}
	
	function selectItem(a){
		input.val($(a).text());
		setTimeout(updateDropdown, 50);
	}
	
	function updateDropdown(){
		drop.html('');
		drop.show();
		if (updateList()){
			html = '';
			$.each(list, function(i){
				html += '<a href="#">' + this + '</a>';
			});
			if (html!=''){
				drop.html(html);
				drop.find('a').click(function(ev){
					selectItem(this);
					return false;
				});
			} else drop.hide();
		}
	}
	
	function install(){
		if (typeof options.root != 'undefined') root = options.root;
		if (typeof options.filter != 'undefined') filter = options.filter;
		showDefault();
		
		input.attr('autocomplete', 'off');
		
		drop = input.wrap('<div class="rel"/>').before('<div class="abs fsdropdown" style="display:none"/>').prev();
		drop.css('marginTop', input.outerHeight()).css('width', input.outerWidth()-2);
		
		input.parents('form').submit(function(ev){
			if (input.hasClass('default_path') || input.val()==root+'...') input.val('');
			return true;
		});
		
		input.focus(function(ev){
			if (input.hasClass('default_path')){
				input.removeClass('default_path');
				input.val(input.val().replace(/\.\.\.$/, ''));
			}
			updateDropdown();
		});
		
		input.blur(function(ev){
			showDefault();
			drop.hide();
		});
		
		input.keyup(function(ev){
			if (drop.is(":visible"))
			switch (ev.which){
				case 27:
					drop.hide();
					ev.preventDefault();
					return false;
					break;
				case 13:
					var ls = drop.find('a.sel');
					if (!ls.length) return true;
					ev.preventDefault();
					ls.click();
					break;
				case 38:
					var ls = drop.find('a.sel');
					if (ls.length) ls = ls.removeClass('sel').prev().addClass('sel');
					if (!ls.length) ls = drop.find('a:last').addClass('sel');
					ev.preventDefault();
					return false;
					break;
				case 40:
					var ls = drop.find('a.sel');
					if (ls.length) ls = ls.removeClass('sel').next().addClass('sel');
					if (!ls.length) ls = drop.find('a:first').addClass('sel');
					ev.preventDefault();
					return false;
					break;
			}
			
			updateDropdown();
		});
		
		$(document).mousedown(function(ev){
			if (drop.is(":hidden")) return true;
			if ($(ev.target).parents('.fsdropdown').length || $(ev.target).is('.fsdropdown')){
				ev.preventDefault();
				ev.stopPropagation();
				return false;
			} else input.blur();
			return true;
		});
	}
	
	install();
	
}