<?php

class docs extends module {

    var $name = "docs";
    var $title = "Материалы";
    var $module_category = "Контент"; 	
	
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
    switch ($this->view_mode){
	   case 'view_docs':
            $this->view_docs($out);
            break;
       case 'embed':
            $this->embed($out);
            break;            
    }
}

function admin(&$out){
	if ($ui = $_REQUEST['unblock_id']){
		SQLExec("UPDATE docs SET blocked=0 WHERE id='$ui' AND redactor_id=".ADMIN_ID);
	}
	
    switch ($this->view_mode){
    	case '': case 'list_docs':
    		$this->list_docs($out);
    		break;
    	case 'edit_docs':
    		$this->edit_docs($out);
    		break;
        case 'delete_docs':
        	SQLExec("UPDATE docs SET deleted=1 WHERE id='{$this->id}'");
            $this->redirect();
            break;    		
    }
}

function edit_docs(&$out){
	require_once('edit_docs.inc.php');
}

function list_docs(&$out){
    require_once('list_docs.inc.php');
}

function view_docs(&$out){
    $rec = SQLSelectOne($q="SELECT * FROM docs WHERE id='{$this->id}'");
    if (!$rec['id']) error404();
    if (!$rec['active']) error404('403 Forbidden');
    if ($rec['deleted']) error404('410 Gone');
    out($rec, $out);
    
    if ($rec['meta_title']!='') $GLOBALS['front']->data['page_title'] = $rec['meta_title'].' - '.SETTINGS_SITE_TITLE;
    else $GLOBALS['front']->data['page_title'] = $rec['title'].' - '.SETTINGS_SITE_TITLE;
    if ($rec['meta_keywords']!='') $GLOBALS['front']->data['meta_keywords'] = $rec['meta_keywords'];
    if ($rec['meta_description']!='') $GLOBALS['front']->data['meta_description'] = $rec['meta_description'];
    
    $out['text'] = applyFilters($out['text'], array('jwplayer','ckimages','targetblank','sounduk_nowrap'));
    $out['title'] = applyFilters($out['title'], array('sounduk_nowrap'));
    
    if ($GLOBALS['front']->data['section_title']=='') $GLOBALS['front']->data['section_title'] = $rec['title'];
}

function embed(&$out){
    $rec = SQLSelectOne($q="SELECT * FROM docs WHERE id='{$this->id}'");
    if (!$rec['id'] || $rec['deleted']){
    	$out['text'] = '<b style="color:red">Материал не найден</b>';
        return;
    }
    if (!$rec['active']) return;
    
    out($rec, $out);
    $out['text'] = applyFilters($out['text'], array('jwplayer','ckimages','targetblank','sounduk_nowrap'));
}

}