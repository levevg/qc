<?php

class idioms extends module {

    var $name = "idioms";
    var $title = "Фразеологизмы";
    var $module_category = "Словарь";

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
        if (IS_AJAX) {
            header ("Content-Type: application/json; charset=".PROJECT_CHARSET);
            echo $this->ajax();
            die;
        }

        switch ($this->view_mode){
            case '': case 'list_idioms':
                $this->view_mode = 'list_idioms';
                $this->list_idioms($out);
                break;
            case 'edit_idioms':
                $this->edit_idioms($out);
                break;
            case 'sources':
                $this->sources($out);
                break;
        }
    }

    function list_idioms(&$out) {
        require_once('list_idioms_admin.inc.php');
    }

    function edit_idioms(&$out) {
        require_once('edit_idioms_admin.inc.php');
    }

    function ajax() {
        if ($_REQUEST['term']) {
            $s = mes($_REQUEST['term']);
            $sources = SQLSelect("SELECT title FROM sources WHERE title LIKE \"%$s%\" ORDER BY (title LIKE \"$s%\") DESC, title ASC");
            $sources = array_map(current, $sources);
            return json_encode($sources);
        }
        return "";
    }
}