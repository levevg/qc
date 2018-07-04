$.preloadImages = function() {
	var a = (typeof arguments[0] == 'object')? arguments[0] : arguments;
	for(var i = a.length-1; i>=0; i--){
		jQuery("<img>").attr("src", a[i]);
	}
}

$.preloadImages(['/img/ajax.gif']);


$(function(){
	$('div.popover').prepend('<div class="arrow"></div>');
});