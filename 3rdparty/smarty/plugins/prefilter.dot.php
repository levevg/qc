<?php

function encodeDots($m){
	return preg_replace_callback('/\s[\w\.]+=/', function($m){ return str_replace(".", "__dot__", $m[0]); }, $m[0]);
}

function smarty_prefilter_dot($source, $smarty){
    return preg_replace_callback('/\{_.+?\}/', encodeDots, $source);
}