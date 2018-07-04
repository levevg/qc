<?php

    include 'config.php';

    $fs = explode(',', $_REQUEST['files']);
    
    $delim = "\n\n";
    
    $mtime = 0;
    $size = 0;
    $files = array();

    foreach ($fs as $file) {
        if ((substr($file,-3)=='.js' || substr($file,-4)=='.css') && is_file($file)){ // security check
            $files[] = $file;
            $mtime = max($mtime, filemtime($file));
            $size += filesize($file) + strlen($delim);
        }
    }
    
    if (substr($files[0],-3)=='.js') $out_mime = 'application/x-javascript';
    elseif (substr($files[0],-4)=='.css') $out_mime = 'text/css';
    else die;
    
    header("Content-Type: $out_mime");
    header('Last-Modified: '.gmdate('D, d M Y H:i:s e', $mtime));
    
    if(isset($_SERVER["HTTP_IF_MODIFIED_SINCE"])){
        $if_modified_since = strtotime(preg_replace('/;.*$/','',$_SERVER["HTTP_IF_MODIFIED_SINCE"]));
        if($if_modified_since >= $mtime){
            header("HTTP/1.0 304 Not Modified");
            exit();
        }
    }
    
    ob_start("ob_gzhandler");
    foreach ($files as $file){
        readfile($file);
        echo $delim;
    }