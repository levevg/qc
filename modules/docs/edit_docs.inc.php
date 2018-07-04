<?php

    $GLOBALS['admin']->data['upload_path'] = './media/upload/docs/';

    $rec = SQLSelectOne("SELECT * FROM docs WHERE id='{$this->id}'");
    
    if ($rec['id']) SQLExec("UPDATE docs SET date_opened=NOW(), blocked=1, redactor_id=".ADMIN_ID." WHERE id='$rec[id]'"); 
    else $rec = array('active' => 1, 'date' => date('Y-m-d 12:00:00')); 
    
    if ($this->mode=='save'){
    	
    	$ok = 1;

        $rec['meta_title'] = $_REQUEST['meta_title'];
        $rec['meta_keywords'] = $_REQUEST['meta_keywords'];
        $rec['meta_description'] = $_REQUEST['meta_description'];
        
    	$rec['title'] = $_REQUEST['title'];
    	if ($rec['title']==''){
    		$out['err_title'] = 1;
    		$ok = 0;
    	}
    	
    	$rec['text'] = $_REQUEST['text'];
    	
    	$rec['active'] = (int)$_REQUEST['active'];
    	
    	if ($ok){
    		$rec['blocked'] = $_REQUEST['close'] ? 0 : 1;
    		$rec['redactor_id'] = ADMIN_ID;
    		$rec['date_opened'] = $rec['date_changed'] = date('Y-m-d H:i:s');
    		
    		if ($rec['id']) SQLUpdate('docs', $rec);
    		else {
                $rec['date_added'] = $rec['date_changed'] = date('Y-m-d H:i:s');
                $rec['author_id'] = ADMIN_ID;
                $this->id = $rec['id'] = SQLInsert('docs', $rec);
    		}
    		
    		$out['ok'] = 1;
    		if ($_REQUEST['close']){
    			$this->redirect(array('mode'=>'ok'));
    			exit;
    		}
    	} else $out['err'] = 1;

    	removeUnusedUploads($_REQUEST['__uploaded_files'], $rec['text']);
    	
    }

    out($rec, $out);