<?php

	($dir = @opendir("./include/autoload")) || fail("Autoload failed", __FILE__, __LINE__);
	
	while ($file = readdir($dir))
		if (preg_match("/\.php$/i", $file))
			include_once("./include/autoload/$file");
			
	closedir($dir);
    
	require_once('modules/settings/settings.class.php');
	
function __autoload($class_name){
    require_once DIR_MODULES."$class_name/$class_name.class.php";
}