<?php

class settings extends module {

    var $name = "settings";
    var $title = "Настройки";
    var $module_category = "Система"; 	
	
function run(){
	$out = array();
	
	if ($this->mode=='save'){
		$settings = SQLSelect("SELECT * FROM settings ORDER BY priority DESC");
		foreach ($settings as &$var){
            $ok = 1;
			switch ($var['type']){
				case 'int':
					if (!preg_match('/^\-?\d+$/', $_REQUEST[$var['name']])){
						$ok = 0;
						$out['err'] = 1;
						$var['err'] = 1;
					}
                    $var['value'] = (int)$_REQUEST[$var['name']];
                    break;
				case 'text':
				default:
                    $var['value'] = $_REQUEST[$var['name']];
					break;
			}
			if ($ok){
				$out['ok'] = 1;
				SQLUpdate('settings', $var);
			}
		}
		$out['settings'] = $settings;
	} else $out['settings'] = SQLSelect("SELECT * FROM settings ORDER BY priority DESC");
	
	$this->data = $out;
}	

static function load(){
	dbConnect(DB_HOST, DB_NAME, DB_USER, DB_PASS);
	$settings = SQLSelect("SELECT * FROM settings");
	foreach ($settings as $s){
		if (!defined('SETTINGS_'.$s['name'])){
			define('SETTINGS_'.$s['name'], $s['value']);
		}
	}
}

}