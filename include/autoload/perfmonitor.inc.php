<?php

function getmicrotime(){
    list($usec, $sec) = explode(' ', microtime());
    return (float)$usec + (float)$sec;
}

function startMeasure($mpoint) {
    global $perf_data;
    $tmp = getmicrotime();
    $perf_data[$mpoint]['START'] = getmicrotime();
}

function endMeasure($mpoint) {
    global $perf_data;
    $perf_data[$mpoint]['END']=getmicrotime();
    $perf_data[$mpoint]['TIME'] += $perf_data[$mpoint]['END'] - $perf_data[$mpoint]['START'];
    $perf_data[$mpoint]['NUM']++;
}

function performanceReport($hidden=1) {
    global $perf_data;
    echo "<!-- BEGIN PERFORMANCE REPORT\n";
    foreach ($perf_data as $k => $v) {
	    if ($perf_data['TOTAL']['TIME']) {
	        $v['PROC']=((int)($v['TIME']/$perf_data['TOTAL']['TIME']*100*100))/100;
	    }
	    $rs="$k (".$v['NUM']."): ".round($v['TIME'], 4)." ".round($v['PROC'], 2)."%";
	    if (!$v['NUM']) {
	        $tmp[] = "Not finished $k";
	    }
	    $tmp[] = $rs;
    }
    echo implode("\n", $tmp);
    echo "Peak memory usage: ".round(memory_get_peak_usage()/1024/1024,1)."M\n";
    echo "\n END PERFORMANCE REPORT -->";
}

?>