<?php

class structure extends module {

    var $name = "structure";
    var $title = "Структура";
    var $module_category = ""; 	
	
function run(){
	$out = array();
	
    switch ($this->action){
        case 'admin':
            $this->admin($out);
            break;
        case '':
        default:

            break;
    }	
	
	$this->data = $out;
}	

function admin(&$out){
    switch ($this->view_mode){
        case '': case 'list_structure':
            $this->list_structure_admin($out);
            break;
        case 'edit_structure':
            $this->edit_structure($out);
            break;
    }
}

function list_structure_admin(&$out){
	$rs = SQLSelect("SELECT * FROM structure");
	$p = array();
	$res = array();
	foreach ($rs as $r) $p[$r['parent_id']][] = $r;
	$q = array(array('0',0));
	while (!empty($q)){
		list($k, $level) = end($q);
		if (empty($p[$k])) array_pop($q);
		else {
			$l = array_shift($p[$k]);
			$l['level'] = $level;
			$res[] = $l;
			$q[] = array($l['id'],$level+1);
		}
	}
    $out['result'] = $res;
}

function edit_structure(&$out){
	$rec = SQLSelectOne("SELECT * FROM structure WHERE id='{$this->id}'");
	if ($this->mode=='save'){
		$ok = 1;
		
		$rec['link'] = $_REQUEST['link'];
		if ($rec['link']=='' || @preg_match("/$rec[link]/",'')===false){
			$ok = 0;
			$out['err_link'] = 1;
		}
		
		$rec['params'] = $_REQUEST['params'];
		if ($rec['params']=='' || !is_array(@json_decode($rec['params'],true))){
            $ok = 0;
            $out['err_params'] = 1;
		}
		
		$rec['parent_id'] = (int)$_REQUEST['parent_id'];
		
		if ($ok){
			if ($rec['id']) SQLUpdate('structure', $rec);
			else $this->id = $rec['id'] = SQLInsert('structure', $rec);
			$out['ok'] = 1;
		} else $out['err'] = 1;
	}
	out($rec, $out);
	
    $rs = SQLSelect("SELECT * FROM structure WHERE id!='$rec[id]'");
    $p = array(); $res = array();
    foreach ($rs as $r) $p[$r['parent_id']][] = $r;
    $q = array(array('0',0));
    while (!empty($q)){
        list($k, $level) = end($q);
        if (empty($p[$k])) array_pop($q);
        else {
            $l = array_shift($p[$k]);
            $l['level'] = $level;
            $l['link'] = str_repeat('&nbsp;&nbsp;&nbsp;', $level).$l['link'];
            $res[] = $l;
            $q[] = array($l['id'],$level+1);
        }
    }
    $out['pages'] = $res;	
}

}