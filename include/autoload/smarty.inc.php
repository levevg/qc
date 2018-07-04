<?php

    define('SMARTY_DIR', ROOT.'3rdparty/smarty/');
	require(SMARTY_DIR.'Smarty.class.php');

	function newSmarty(){	
		$smarty = new Smarty();
	
		$smarty->template_dir = DIR_TEMPLATES;
		$smarty->compile_dir = rtrim(DIR_TEMPLATES,'/').'_c/';
		$smarty->compile_check = true;
		$smarty->caching = false;
		
		$smarty->loadFilter('pre', 'dot');
		$smarty->loadFilter('pre', 'inc');
		
		//$smarty->force_compile = true;
		
		return $smarty;
	}