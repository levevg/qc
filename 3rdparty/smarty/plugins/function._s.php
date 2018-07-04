<?php

function smarty_function__s($params, &$smarty){
	$p = array();
	if (is_object($smarty->module->owner)) $smarty->module->owner->collectParams($p);
	$my = array();
	foreach ((array)$params as $k => $v)
		if (preg_match('/(\w+)__dot__(\w+)/', $k, $m)){
			$p[$m[1]][$m[2]] = $v;
		} else $my[$k] = $v;
	$p[$smarty->module->name] = $my;
	return module::params2str($p,'');
}