<?php

    error_reporting(0);

    header('Content-type: application/json; charset=utf-8');
    
    $root = 'media';
    
    $path = trim($_REQUEST['path'],'/');
    
    $r = array();
    
    $filter = $_REQUEST['filter'];
    
    if (strpos($path, $root)===0 && !is_file($path)){
    	
    	if (!is_dir($path)){
	        $t = explode('/', trim($_REQUEST['path'],'/'));
	        $prefix = array_pop($t);
	        $path = implode('/', $t);
    	} else $prefix = '';
    	
    	if (is_dir($path)){
	    	$path = $path.'/';
	    	$d = opendir($path);
	    	while (($f=readdir($d))!== false)
	    	   if ($f[0]!='.' && ($prefix==''||strpos($f, $prefix)===0) &&
	    	          ($filter=='' || is_dir($path.$f) || preg_match($filter, $f)))
	    	      $r[] = htmlspecialchars('/'.$path.$f).(is_dir($path.$f) ? '/' : '');
	    	closedir($d);
	    	sort($r);
	    	
	    	$t = explode('/', trim($_REQUEST['path'],'/'));
	    	array_pop($t);
	    	$back = implode('/', $t);
	    	if (strpos($back, $root)===0) array_unshift($r, htmlspecialchars('/'.$back));
    	}
    }
    
    $result = array('path' => $_REQUEST['path'], 'list' => $r);
    
    echo json_encode($result);