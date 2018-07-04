<?

    include_once("./config.php");
    include_once("./include/errors.php");
    include_once("./include/autoload.php");

    startMeasure('TOTAL');

    include_once(DIR_MODULES.'admin.class.php');
    
    $session = new session("sess");
    dbConnect(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    
    settings::load();
    
    define('SCRIPT_NAME', $_SERVER['PHP_SELF'].'?');

    $module = 'admin';

    $ajax = $_REQUEST['ajax'];
    if ($ajax!=''){
        if (!class_exists($ajax) && is_file(DIR_MODULES."$ajax/$ajax.class.php")) require_once DIR_MODULES."$ajax/$ajax.class.php";
        if (class_exists($ajax)){
            $module = $ajax;
        }
    }

    define('IS_AJAX', $module!='admin');

    $admin = new $module();

    if (IS_AJAX) {
        $admin->action = "admin";
    }

    $result = $admin->execute();
    
    if (!headers_sent()) {
        header ("HTTP/1.0: 200 OK\n");
        header ('Content-Type: text/html; charset='.PROJECT_CHARSET);
    }
    if (USE_GZ_OUTPUT) ob_start("ob_gzhandler");
    echo $result;
   
    $session->save();
    dbDisconnect();

    endMeasure('TOTAL');
    
    //performanceReport();
