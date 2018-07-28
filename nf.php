<?php

include_once("./config.php");
include_once("./include/errors.php");
include_once("./include/autoload.php");
dbConnect(DB_HOST, DB_NAME, DB_USER, DB_PASS);

if (isset($_SERVER['REDIRECT_QUERY_STRING'])) {
    parse_str($_SERVER['REDIRECT_QUERY_STRING'], $a);
    foreach ((array)$a as $k => $v){
        $_GET[$k] = $v;
        $_REQUEST[$k] = $v;
    }
}

function replaceMatches(&$v, $k){
	global $m;
	$v = preg_replace('/\\\\(\d+)/e', '$m[(int)\1]', $v);
}

$pages = SQLSelect("SELECT id, link, params, parent_id FROM structure");

foreach($pages as $page){
	if (preg_match("/$page[link]/is", $_SERVER["REQUEST_URI"], $m)){
		$params = json_decode(str_replace('\\', '\\\\', $page['params']), true);
		if (count($m)>1) array_walk_recursive($params, 'replaceMatches');
	    $GLOBALS['modules_params'] = $params;
	    $GLOBALS['current_page'] = $page;
	    break;
	}
}

if (!isset($GLOBALS['modules_params'])){
	$page = SQLSelectOne("SELECT * FROM structure WHERE '".mes($_SERVER["REQUEST_URI"])."' LIKE link");
	if ($page['id']){
		$GLOBALS['modules_params'] = json_decode($page['params'], true);
	}
}

if (!isset($GLOBALS['modules_params'])) error404();

include_once("index.php");

?>