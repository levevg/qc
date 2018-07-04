<?php

class tags extends module {

    var $name = "tags";
    var $title = "Атрибуты (сокращения)";
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
        switch ($this->view_mode){
            case '': case 'list_attrs':
                $this->view_mode = 'list_attrs';
                $this->tab = 'attrs';
                $this->list_tags($out, 'a');
                break;
            case 'list_tags':
                $this->tab = 'tags';
                $this->list_tags($out, 'm');
                break;
            /*
            case 'edit_docs':
                $this->edit_docs($out);
                break;
            case 'delete_docs':
                SQLExec("UPDATE docs SET deleted=1 WHERE id='{$this->id}'");
                $this->redirect();
                break;*/
        }
    }

    function list_tags(&$out, $type){
        $sql = "SELECT tags.*, GROUP_CONCAT(language, ':', name ORDER BY language SEPARATOR '\n') AS names";
        if ($type == 'a') $sql .= ", GROUP_CONCAT(language, ':', description ORDER BY language SEPARATOR '\n') AS descriptions";
        $sql .= " FROM tags JOIN tags_localized ON (tags.id = tag_id) WHERE type='".mes($type)."'";
        if ($_GET['lang']) {
            $sql .= " AND language='".mes($_GET['lang'])."'";
        }
        $sql .= " GROUP BY tag_id ORDER BY names";

        $out['tags'] = SQLSelect($sql);
    }


}