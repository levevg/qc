<?php

class languages extends module {

    var $name = "idioms";
    var $title = "Языки";
    var $module_category = "Словарь";

    private static $langs = null;
    private static $langsByCode = null;

    function run(){
        $out = array();

        switch ($this->action){
            case 'admin':
                $this->admin($out);
                break;
            case '':
            default:
                $this->front($out);
                break;
        }

        $this->data = $out;
    }

    function front(&$out){
    }

    function admin(&$out){
    }

    static function all(){
        if (!self::$langs) {
            self::$langs = SQLSelect("SELECT * FROM languages");
        }
        return self::$langs;
    }

    static function allByCode(){
        if (!self::$langsByCode) {
            $all = self::all();
            self::$langsByCode = array();
            foreach ($all as $lang) {
                self::$langsByCode[$lang['code']] = $lang;
            }
        }
        return self::$langsByCode;
    }

}