<?php

    $sortby = 'generator';
    $sortdir = 'ASC';
    if (in_array($_REQUEST['sortby'], array('generator', 'definition', 'language'))) $sortby = $_REQUEST['sortby'];
    if (in_array($_REQUEST['sortdir'], array('ASC', 'DESC'))) $sortdir = $_REQUEST['sortdir'];
    $out['sortby'] = $sortby;
    $out['sortdir'] = $sortdir;
    $out['sortdirinv'] = $sortdir=='ASC' ? 'DESC' : 'ASC';

    $qry = 'deleted=0';

    $paging_params = "&sortby=$sortby&sortdir=$sortdir";

    if ($_REQUEST['q']!=''){
        $out['q'] = $_REQUEST['q'];
        $paging_params .= '&q='.rawurlencode($out['q']);
        $q = '%'.mes(mb_strtolower($_REQUEST['q'],'utf-8')).'%';
        $qry .= " AND (generator LIKE '$q' OR definition LIKE '$q')";
    }

    $total = SQLSelectVal("SELECT COUNT(*) FROM idioms WHERE $qry");
    $perpage = 30;
    $page = $_REQUEST['pg'];
    paging($out, $total, $page, $perpage, $from);

    $idioms = SQLSelect("SELECT * FROM idioms WHERE $qry ORDER BY $sortby $sortdir LIMIT $from, $perpage");

    $out['idioms'] = $idioms;
    $out['paging_params'] = $paging_params;