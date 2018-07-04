<?php

define('MATCH_OFFSET_BITS', 10);
define('MATCH_LENGTH_BITS', 5);
define('MIN_COMPRESSED_LENGTH', (int)((MATCH_OFFSET_BITS + MATCH_LENGTH_BITS + 1)/8));
define('MAX_COMPRESSED_LENGTH', (1<<MATCH_LENGTH_BITS) + MIN_COMPRESSED_LENGTH);
define('_IDX', 0);
define('_STR', 1);
define('MAX_DICTIONARY_LENGTH', (1<<MATCH_OFFSET_BITS) + MIN_COMPRESSED_LENGTH - 1);

if ((MATCH_OFFSET_BITS + MATCH_LENGTH_BITS + 1) % 8) die('(MATCH_OFFSET_BITS+MATCH_LENGTH_BITS+1) must be divisible by 8');

class url_compressor {

static $dictionary_plain = 'A:action=docs:id=:admin:view_mode=edit:tab=profile=admin_userspresstructure';
static $dictonary = null;

static function compress($data){
	if (self::$dictonary==null) self::buildDictionary();
	
	$i = 0;
	$out = '';
	while ($i < strlen($data)){
		$c = ord($data[$i]);
		
		$match = false;
		
		if ($i <= strlen($data) - MIN_COMPRESSED_LENGTH){
			$m = substr($data, $i, MIN_COMPRESSED_LENGTH);
			if (isset(self::$dictonary[$m])){
				$len = MIN_COMPRESSED_LENGTH;
				$j = 0;
				$match_idx = self::$dictonary[$m][$j][_IDX];
				$match_len = $len;
				$maxlen = min(MAX_COMPRESSED_LENGTH, strlen($data) - $i);
				while ($j < count(self::$dictonary[$m]) && $len < $maxlen){
					if (self::$dictonary[$m][$j][_STR][$len-MIN_COMPRESSED_LENGTH]==$data[$i+$len]) ++$len;
					else {
						$match_idx = self::$dictonary[$m][$j][_IDX];
						$match_len = $len;
						++$j;
						$len = MIN_COMPRESSED_LENGTH;
					};
				}
				$i += $match_len;
				$match = true;
				
				$m = base_convert($match_idx, 10, 2);
				$m = str_repeat('0', MATCH_OFFSET_BITS - strlen($m)).$m;
				$l = base_convert($match_len - MIN_COMPRESSED_LENGTH, 10, 2);
				$l = str_repeat('0', MATCH_LENGTH_BITS - strlen($l)).$l;
				$o = (int)base_convert("1$m$l", 2, 10);
				$out .= chr($o>>8).chr($o&255);
				
			}
		}
		
		if (!$match){
			if ($c < 128) $out .= $data[$i];
			else $out .= chr(0).$data[$i];
			++$i;
		}
	}
	
	//echo "<br><br>$data<br>";
	//for ($i = 0; $i < strlen($out); ++$i) echo base_convert(ord($out[$i]), 10, 16).' ';
	
	$data = $out;
	
	return str_replace(array('=','/','+'), array('.', '_', '-'), base64_encode($data)); /*
	return urlencode($data); //*/
}

static function uncompress($data){
	if (self::$dictonary==null) self::buildDictionary();
	$data = base64_decode(str_replace(array('.', '_', '-'), array('=','/','+'), $data));
	$i = 0;
	$out = '';
	while ($i < strlen($data)){
		$o = ord($data[$i]);
		if ($o == 0){
			$out .= $data[$i+1];
			$i += 2;	
		} elseif ($o < 128){
			$out .= $data[$i];
			++$i;
		} else {
			$c = ord($data[$i])*256 + ord($data[$i+1]);
			$b = base_convert($c, 10, 2);
			$o = base_convert(substr($b, 1, MATCH_OFFSET_BITS), 2, 10);
			$l = base_convert(substr($b, MATCH_OFFSET_BITS+1), 2, 10);
			$out .= substr(self::$dictionary_plain, $o, $l + MIN_COMPRESSED_LENGTH);
			$i += 2;
		}
	}
	return $out; /*
	return urldecode($data); //*/
}

static function buildDictionary(){
/*	complete dictionary with modules list. NOT RECOMMENDED FOR USE
 
    if (strlen(self::$dictionary_plain) < MAX_DICTIONARY_LENGTH){
		self::$dictionary_plain = substr(self::$dictionary_plain.implode('', array_keys(module::$project_modules)), 0, MAX_DICTIONARY_LENGTH);
	}*/
	self::$dictonary = array ();
	for ($i = 0; $i < strlen(self::$dictionary_plain) - MIN_COMPRESSED_LENGTH; ++$i){
		self::$dictonary[substr(self::$dictionary_plain, $i, MIN_COMPRESSED_LENGTH)][] = 
			array(_STR => substr(self::$dictionary_plain, $i+MIN_COMPRESSED_LENGTH, MAX_COMPRESSED_LENGTH-1),
				  _IDX => $i);
	}
}
	
}