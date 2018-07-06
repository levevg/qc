<?php

class front extends module {

var $no_install = true;
	
function run(){
	if ($this->action=='error404') error404();

    $out = array('page_title' => SETTINGS_SITE_TITLE);

    $this->template = 'index.tpl';
    $this->data = $out;
}


}
