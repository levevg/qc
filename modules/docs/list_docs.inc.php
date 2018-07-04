<?php

    SQLExec("UPDATE docs SET blocked=0 WHERE date_opened + INTERVAL ".SETTINGS_BLOCK_TIMEOUT." SECOND < NOW()");

    $qry = 'deleted=0';
    
    $paging_params = '';
    
    if ($_REQUEST['q']!=''){
    	$out['q'] = $_REQUEST['q'];
        $paging_params .= '&q='.rawurlencode($out['q']);
    	$q = '%'.mysql_real_escape_string(mb_strtolower($_REQUEST['q'],'utf-8')).'%';
        $qry .= " AND (title LIKE '$q' OR intro LIKE '$q' OR text LIKE '$q')";
    }
    
    $total = SQLSelectVal("SELECT COUNT(*) FROM docs WHERE $qry");
    $perpage = 20;
    $page = $_REQUEST['pg'];
    paging($out, $total, $page, $perpage, $from);
    $sortby = 'docs.id ASC';
    
    $admins = arrayAssoc(SQLSelect("SELECT id, login FROM admin_users"));

    $res = SQLSelect("SELECT id, DATE_FORMAT(date, '%d.%m.%Y') as `date`, title,
                             active, blocked, author_id, redactor_id, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_opened) AS opened_ago
                      FROM docs
                      WHERE $qry
                      ORDER BY $sortby
                      LIMIT $from, $perpage");
    
    foreach ($res as &$rec){
    	$rec['author'] = $admins[$rec['author_id']]['login'];
    	$rec['redactor'] = $admins[$rec['redactor_id']]['login'];
    	if ($rec['blocked']) $rec['opened_time'] = timeInterval($rec['opened_ago']);
    }
    
    $out['result'] = $res;
    $out['paging_params'] = $paging_params;