<?php

class admin extends module {

var $no_install = true;
	
function run(){
	global $session;
    $out = array('page_title' => SETTINGS_SITE_TITLE);
    
    define('ADMIN_ID', (int)$session->data['admin_id']);
    
    if (ADMIN_ID){
    	$admin = SQLSelectOne("SELECT * FROM admin_users WHERE id=".ADMIN_ID);
    	SQLExec("UPDATE admin_users SET last_action=NOW() WHERE id=".ADMIN_ID);
    	$out['me'] = $admin;
    }
    
    $out['here'] = SQLSelect("SELECT login FROM admin_users WHERE last_action>=NOW() - INTERVAL 5 MINUTE");

    $out['modules'] = SQLSelect("SELECT * FROM project_modules WHERE hidden=0 ORDER BY priority DESC");
    
    $this->template = 'admin.tpl';
    $this->data = $out;
}

}
