<?php

function smarty_function_img($params, &$smarty){
	$atts = array();
	if ($params['width']) $attrs[] = 'width="'.$params['width'].'"';
    if ($params['height']) $attrs[] = 'height="'.$params['height'].'"';
    if ($params['alt']) $attrs[] = 'alt="'.hsc($params['alt']).'"';
    $p = array();
    if ($params['w']) $p[] = 'w='.$params['w'];
    if ($params['h']) $p[] = 'h='.$params['h'];
    if ($params['src']) $attrs[] = 'src="/thumb.php?src='.rawurlencode($params['src']).'&'.implode('&',$p).'"';
	return '<img '.implode(' ', $attrs).'/>';
}