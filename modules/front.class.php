<?php

class front extends module {

var $no_install = true;
	
function run(){
	if ($this->action=='error404') error404();

	if ($this->action=='') {
        if ($_SERVER['PHP_AUTH_USER'] != AUTH_USER || $_SERVER['PHP_AUTH_PW'] != AUTH_PASS) {
            header('WWW-Authenticate: Basic realm="index"');
            header('HTTP/1.0 401 Unauthorized');
            die('Пользователь - название чата, пароль - название команды');
        }
    }

    $out = array('page_title' => SETTINGS_SITE_TITLE);

    $this->template = 'index.tpl';
    $this->data = $out;
}


}
