<?

$GLOBALS['monthes'] = array('', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

function month($i){
	return $GLOBALS['monthes'][(int)$i];
}

function debmes($text){
    $today_file = ROOT.'debmes/'.date('Ymd').'.txt';
    $f = fopen($today_file, "a+");
    if ($f) {
        fputs($f, date("d.m.Y H:i:s")."\n$text\n");
        fclose($f);
    }
}

function out($rec, &$out, $prefix=''){
	foreach ((array)$rec as $k => $v) $out[$prefix.$k] = $v;
}

function mes($str){
    global $dbLink;
    return mysqli_escape_string($dbLink, $str);
}

function hsc($str){
    return htmlspecialchars($str);
}

function ajaxHeaders($mime='text/html'){
	if (headers_sent() || defined('IS_AJAX')) return;
	define('IS_AJAX', true);
    header ("HTTP/1.0: 200 OK");
    header ("Content-Type: $mime; charset=".PROJECT_CHARSET);
}

function redirect($url, $code=null){
	if (headers_sent() || defined('IS_AJAX')){
		echo '<script>//window.location="'.addslashes($url).'";</script>';
		exit;
	}
	if ($code!==null) header("HTTP/1.0: $code");
	header("Location: $url");
	exit;
}

function error404($status='404 Not found'){
	ob_clean();
    header ("HTTP/1.0: $status");
    header ("Content-Type: text/html; charset=".PROJECT_CHARSET);
    include_once(ROOT.'404.html');
    exit;
}

function arrayAssoc($arr, $key='id'){
    $r = array();
    foreach ($arr as $i)
        $r[$i[$key]] = $i;
    return $r;	
}

function timeInterval($interval){
	$t = abs($interval);
	$days = floor($t/86400);
	$t -= $days*86400;
	$hours = floor($t/3600);
	$t -= $hours*3600;
	$minutes = floor($t/60);
    $t -= $minutes*60;
    $seconds = round($t);
    $r = array();
    if ($days>0) $r[] = "$days дн";
    if ($hours>0) $r[] = "$hours час";
    if ($minutes>0) $r[] = "$minutes мин";
    if ($seconds>0) $r[] = "$seconds сек";
    if ($interval<0) return 'через '.implode(' ', $r);
    else return implode(' ', $r).' назад';
}

function paging(&$out, $total, &$page, $perpage, &$from){
	$pages = ceil($total / $perpage);
	$out['total_pages'] = $pages; 
	$page = min(max((int)$page, 1), $pages);
    $out['current_page'] = $page; 
	$from = max(0, ($page - 1) * $perpage);
    if ($pages<2) return;
    $out['paging'] = true;
    if ($page>1) $out['prev_page'] = $page-1;
	if ($page>2) $out['first_page'] = 1;
    if ($page<$pages) $out['next_page'] = $page+1;
    if ($page<$pages-1) $out['last_page'] = $pages;
	$out['pages'] = array();
	for ($i = 1; $i <= $pages; ++$i){
	   $out['pages'][$i] = array(
           'page' => $i,
	       'current' => $i==$page,
	   );	
	}
}

function translit($str){
    $tl = array('й' => 'j', 'ц' => 'c', 'у' => 'u', 'к' => 'k', 'е' => 'e', 'н' => 'n', 'г' => 'g', 'ш' => 'sh', 'щ' => 'sch', 
		        'з' => 'z', 'х' => 'h', 'ф' => 'f', 'ы' => 'y', 'в' => 'v', 'а' => 'a', 'п' => 'p', 'р' => 'r', 'о' => 'o', 'ё' => 'jo',
		        'л' => 'l', 'д' => 'd', 'ж' => 'zh', 'э' => 'e', 'я' => 'ja', 'ч' => 'ch', 'с' => 's', 'м' => 'm', 'и' => 'i', 
		        'т' => 't', 'б' => 'b', 'ю' => 'ju', 'ь' => '', 'ъ' => '');
    $r = '';
    for ($i = 0; $i < mb_strlen($str); ++$i){
    	$c = mb_substr($str, $i, 1, PROJECT_CHARSET);
    	if (mb_strpos('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890-.', $c, 0, PROJECT_CHARSET)!==false){
    		$r .= $c;
    	} elseif (isset($tl[$c])){
            $r .= $tl[$c];    		
    	} elseif (isset($tl[$c=mb_strtolower($c,PROJECT_CHARSET)])){
    		$r .= mb_strtoupper($tl[$c],PROJECT_CHARSET);
    	} else $r .= '_';
    }
    return preg_replace('/__+/', '_', trim($r, '_'));
}

function removeUnusedUploads($files, $text){
    if ($files=='') return;
    $files = explode(',', trim($files, ','));
    foreach ((array)$files as $file)
    if (strpos($text, $file)===false){
        @unlink('.'.$file);
    }
}

function explode_escaped($sep, $str, $esc='"\''){
    $result = array();
    $str .= $sep;
    $ac = '';
    $i = 0;
    while ($i < strlen($str)){
        if ($str[$i]==$sep){
            $result[] = $ac;
            $ac = '';
            ++$i;    
        } elseif (strpos($esc, $str[$i])!==false){
            $curr_esc = $str[$i];
        	++$i;
            while ($i < strlen($str) && $str[$i]!=$curr_esc){
                $ac .= $str[$i];
                ++$i;
            }
            $result[] = $ac;
            $ac = '';
            $i+=2;
        } else {
            $ac .= $str[$i];
            ++$i;
        }
    }
    return $result;
}

function resizeImage($filename, $new_width=0, $new_height=0, $qual=95){
    if (!is_file($filename)) return false;
    list ($image_width, $image_height, $image_format) = getImageSize($filename);
	if ($image_width==$new_width && $image_height==$new_height) return true;
    $type = 0;
    switch($type){
        case 0:
            if (($new_width!=0) && ($new_width<$image_width)) {
                $image_height=(int)($image_height*($new_width/$image_width));
                $image_width=$new_width;
            }
            if (($new_height!=0) && ($new_height<$image_height)) {
                $image_width=(int)($image_width*($new_height/$image_height));
                $image_height=$new_height;
            }
            break;
        case 1:
            $image_width = $new_width;
            $image_height = $image_height;
        break;
    }
    if ($image_format==1) $old_image = imagecreatefromgif($filename);
    elseif ($image_format==2) $old_image=imagecreatefromjpeg($filename);
    elseif ($image_format==3) $old_image=imagecreatefrompng($filename);
    else return false;
    
    $new_image = imagecreatetruecolor($image_width, $image_height);
    $white = imagecolorallocate($new_image, 255, 255, 255);
    imagefill($new_image, 0, 0, $white);
    
    imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $image_width, $image_height, imagesx($old_image), imagesy($old_image));
    
    imagejpeg($new_image, $filename, $qual);
    return true;
}

function shorten($str, $maxlen = 100){
	if (mb_strlen($str, PROJECT_CHARSET)<$maxlen) return $str;
	$str = mb_substr($str, 0, $maxlen, PROJECT_CHARSET);
	return preg_replace('/\s\S*$/', '...', $str);
}

function strip_html($str){
	return preg_replace(array('/&\w+;/', '/\s+/'), array(' ', ' '), str_replace('&deg;', '°', strip_tags($str)));
}

function isSearchBot($useragent=null){
    if ($useragent==null) $useragent = $_SERVER['HTTP_USER_AGENT'];
    $bots = "Google|Googlebot|Yandex";
    $bots = explode('|', $bots);
    foreach ($bots as $bot)
        if (stripos($useragent, $bot)!==false) return true;
    return false;
}


?>