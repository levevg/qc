<?php

function applyFilters($text, $filters){
	foreach ($filters as $filter)
	   if (function_exists('filter_'.$filter))
	       $text = call_user_func('filter_'.$filter, $text);
    return $text;
}

function filter_ckimages($text){
	if (strpos($text, ' i_')===false) return $text;
	return preg_replace_callback('/<img[^>]+?>/', parseCKImages, $text);
}

function parseCKImages($p){
	$s = ltrim(rtrim(substr($p[0], 5),' />'), ' ');
	$s = preg_replace('/\s\s+/', '\s', $s);
	$p = explode_escaped(' ', $s, '"\'');
	$attrs = array();
	foreach ($p as $a){
		list($attr, $val) = explode('=', $a, 2);
		$attrs[$attr] = $val;
	}
	$prefix = $postfix = '';
	if ($attrs['i_thumb']){
		$t = '';
		if (preg_match('/width:\s*(\d+)[p;]/', $attrs['style'].';', $m1)) $t .= '&w='.$m1[1];
        if (preg_match('/height:\s*(\d+)[p;]/', $attrs['style'].';', $m2)) $t .= '&h='.$m2[1];
		$prefix .= '<a href="'.hsc($attrs['src']).'" rel="enlarge" target="_blank">';
		$attrs['src'] = '/thumb.php?src='.rawurlencode(ltrim($attrs['src'],'/')).$t;
		$postfix .= '</a>';
	}
	unset($attrs['i_width']);
	unset($attrs['i_height']);
	unset($attrs['i_thumb']);
	$result = '<img';
	foreach ($attrs as $attr=>$val)
	   $result .= " $attr=\"$val\"";
	return $prefix.$result.'/>'.$postfix;
}

function filter_targetblank($text){
	if (strpos($text, 'http')===false) return $text;
	return preg_replace_callback('/<a [^>]*?href=[^>]+?>/', parseLinks_, $text);
}

function parseLinks_($p){
	if (strpos($p[0], 'target=')!==false) return $p[0];
	return str_replace('<a ', '<a target="_blank" ', $p[0]);
}

function filter_parse_links($text){
	return preg_replace('/(?:http:\/\/)?([a-z\d\-_\.]*\.[a-z]+)/i', '<a href="http://\1">\1</a>', $text);
}