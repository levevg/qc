<?php

    error_reporting(0);

    if (!is_file($_REQUEST['src'])){
    	header('HTTP/1.0: 404 Not found');
    	exit;
    }

    include('config.php');
    error_reporting(0);
    
    $filename = $_REQUEST['src'];
    
    $new_width = (int)$_REQUEST['w'];
    $new_height = (int)$_REQUEST['h'];
        
    list($image_width, $image_height, $image_format) = getimagesize($filename);

    $orig_width = $image_width;
    $orig_height = $image_height;
    
    if (($new_width!=0) && ($new_width<$image_width)) {
        $image_height=(int)($image_height*($new_width/$image_width));
        $image_width=$new_width;
    }
    if (($new_height!=0) && ($new_height<$image_height)) {
        $image_width=(int)($image_width*($new_height/$image_height));
        $image_height=$new_height;
    }

    switch ($image_format){
        case 1: $create_func = "imagecreatefromgif"; break;
        case 2: $create_func = "imagecreatefromjpeg"; break;
        case 3: $create_func = "imagecreatefrompng"; break;
        default: exit;
    }
    
    if (!$_REQUEST['f']){
        if ($image_format!=2) $_REQUEST['f'] = 'png';
    }
    
    switch ($_REQUEST['f']){
        case 'png':
            $out_func = "imagepng";
            $out_mime = "image/png";
            $out_ext = "png";
            $out_qual = $_REQUEST['qual'] ? $_REQUEST['qual'] : 9;
            break;
        default:
            $fill_bg = 1;
            $out_func = "imagejpeg";
            $out_mime = "image/jpeg";
            $out_ext = "jpg";
            $out_qual = $_REQUEST['qual'] ? $_REQUEST['qual'] : 95;
            break;        
    }

    if ($image_width == $orig_width && $image_height == $orig_height){
        $cache = $filename;
        if(isset($_SERVER["HTTP_IF_MODIFIED_SINCE"])){
            $if_modified_since = strtotime(preg_replace('/;.*$/','',$_SERVER["HTTP_IF_MODIFIED_SINCE"]));
            if($if_modified_since >= @filemtime($cache)){
                header("HTTP/1.0 304 Not Modified");
                exit();
            }
        }
        header("Content-Type: $out_mime");
        header("Content-Length: ".filesize($cache));
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', @filemtime($cache)).' GMT');
        readfile($cache);
        exit;
    }    
    
    $cached_filename = md5($filename.filemtime($filename).$new_width.$new_height).'.'.$out_ext;
    $path_to_cache_file = 'cached/'.substr($cached_filename, 0, 2);
    $cache = $path_to_cache_file.'/'.$cached_filename;
    
    if (!$_REQUEST['dc'] && file_exists($cache) && (time() - filemtime($cache) < 35*86400)){
        if(isset($_SERVER["HTTP_IF_MODIFIED_SINCE"])){
            $if_modified_since = strtotime(preg_replace('/;.*$/','',$_SERVER["HTTP_IF_MODIFIED_SINCE"]));
            if($if_modified_since >= @filemtime($cache)){
                header("HTTP/1.0 304 Not Modified");
                exit();
            }
        }
        header("Content-Type: $out_mime");
        header("Content-Length: ".filesize($cache));
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', @filemtime($cache)).' GMT');
        readfile($cache);
        exit;
    }

    $old_image = $create_func($filename);

    $new_image = imagecreatetruecolor($image_width, $image_height);
    
    if ($fill_bg){
        $white = imagecolorallocate($new_image, 255, 255, 255);
        imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $image_width, $image_height, imagesx($old_image), imagesy($old_image));
    } else {
        imagealphablending($new_image, false);
        $tr = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
        imagefill($new_image, 0, 0, $tr);
        imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $image_width, $image_height, imagesx($old_image), imagesy($old_image));
        imagesavealpha($new_image, true);
    }
    
    if(!$_REQUEST['dc']){
        if (!is_dir($path_to_cache_file)) @mkdir($path_to_cache_file);
        $out_func($new_image, $cache, $out_qual);
        header("Content-Type: $out_mime");
        header("Content-Length: ".filesize($cache));
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', @filemtime($cache)).' GMT');
        readfile($cache);
        exit;
    }
    
    header("Content-type: $out_mime");
    $out_func($new_image, NULL, $out_qual);