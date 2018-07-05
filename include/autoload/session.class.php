<?php

class session {
    var $data;
    var $name;
    
function __construct($name){
    $this->name = $name;

    ini_set('session.use_only_cookies', '1');
    
    session_set_cookie_params(0);
    session_name($name);
    session_start();
    
    $this->data = $_SESSION['DATA'];
}

function save(){
    $_SESSION['DATA'] = $this->data;
}

function close(){
    unset($_SESSION['DATA']);
}

}
