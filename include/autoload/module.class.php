<?php

//define('LOG_URI', 1);

function param_str_compress($data){
    return url_compressor::compress($data);
}

function param_str_decompress($data){
    if (defined('LOG_URI')) {
    	$data = url_compressor::uncompress($data);
        fwrite($f=fopen('uri.txt', 'a'), $data."\n");
        fclose($f);
        return $data;
    }
	return url_compressor::uncompress($data);
}

abstract class module {

    var $name;
    var $data;
    var $instance;
    var $template;
    var $result;
    var $owner;
    var $smarty;
    var $config;
    var $action;
    var $view_mode;
    var $module_category;
    var $title;

    var $no_install = false;

    static $project_modules = NULL;
    
    static $base64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
    static $frombase64 = array('A'=>0,'B'=>1,'C'=>2,'D'=>3,'E'=>4,'F'=>5,'G'=>6,'H'=>7,'I'=>8,'J'=>9,'K'=>10,'L'=>11,'M'=>12,'N'=>13,'O'=>14,'P'=>15,'Q'=>16,
                               'R'=>17,'S'=>18,'T'=>19,'U'=>20,'V'=>21,'W'=>22,'X'=>23,'Y'=>24,'Z'=>25,'a'=>26,'b'=>27,'c'=>28,'d'=>29,'e'=>30,'f'=>31,'g'=>32,
                               'h'=>33,'i'=>34,'j'=>35,'k'=>36,'l'=>37,'m'=>38,'n'=>39,'o'=>40,'p'=>41,'q'=>42,'r'=>43,'s'=>44,'t'=>45,'u'=>46,'v'=>47,'w'=>48,
                               'x'=>49,'y'=>50,'z'=>51,'0'=>52,'1'=>53,'2'=>54,'3'=>55,'4'=>56,'5'=>57,'6'=>58,'7'=>59,'8'=>60,'9'=>61,'-'=>62,'_'=>63);

static function getModules(){
    $pm = SQLSelect("SELECT * FROM project_modules");
    self::$project_modules['admin'] = self::$base64[0];
    self::$project_modules['front'] = self::$base64[1];
    foreach ((array)$pm as $m){
        $m['id'] = $m['id'] + 1;
        $code = str_repeat('_', floor($m['id']/63));
        $code .= self::$base64[$m['id']%63];
        self::$project_modules[$m['name']] = $code;
    }
}

function __construct($params = array()){
	foreach ((array)$params as $k => $v)
	   $this->{$k} = $v;
	   
    $this->name = get_class($this);
    if (!$this->no_install) $this->checkInstalled();
    $this->template = "{$this->name}/{$this->name}.tpl";
    
    global $modules_params, $request_params;
    if (!isset($request_params)){
    	$request_params = module::str2params($_REQUEST['_']);
    	if (!isset($modules_params)) $modules_params = array();
    	out($request_params, $modules_params);
    }

    if (isset($modules_params[$this->name])){
    	/*if (isset($modules_params[$this->name][0])){
    		for ($i = 0; $i < count($modules_params[$this->name]); ++$i)
                if ($modules_params[$this->name][$i]['instance']==$this->instance){
                    $p = $modules_params[$this->name][$i];
                    break;                  
                }
    	} else */
    	// TODO : instances
    	$p = $modules_params[$this->name];
    	foreach ((array)$p as $k => $v)
    	   $this->{$k} = $v;
    }
    
    foreach ((array)$params as $k => $v)
       $this->{$k} = $v;
}

protected static $save_fields = array('id', 'view_mode', 'action', 'tab', 'mode');

function out($out){
    $child = get_class($this);
    $sf = eval("return $child::\$save_fields;");
    if (!is_array($sf)) $sf = self::$save_fields;
    foreach ($sf as $f)
        $out[$f] = $this->{$f};
    
    $this->data = $out;
    
    $this->smarty = newSmarty();
    $this->smarty->assign($this->data);
    $this->smarty->module = $this;
    $result = $this->smarty->fetch($this->template);
    $result = preg_replace_callback('/\{global var=(\w+)\}/', function($m){ return $this->data[$m[1]]; }, $result);
    unset($this->smarty);
    endMeasure($this->name);
    return $result;
}

abstract function run();

function execute(){
	startMeasure($this->name);
	$this->run();
	return $this->out($this->data);
}

function collectParams(&$params){
	if (is_object($this->owner)) $this->owner->collectParams($params);
    $p = array();
    $child = get_class($this);
    $sf = eval("return $child::\$save_fields;");
    if (!is_array($sf)) $sf = self::$save_fields;

    foreach ($sf as $f)
        if (isset($this->{$f})) $p[$f] = $this->{$f};
    if (isset($params[$this->name])){
		if (!isset($params[$this->name][0])) $params[$this->name] = array($params[$this->name]);
		$params[$this->name][] = $p;
	} else $params[$this->name] = $p;
}

static function escapeParam($s){
	return str_replace(array(':', ';', '='), array('%3A', '%3B', '%3D'), $s);
}

static function unescapeParam($s){
    return str_replace(array('%3A', '%3B', '%3D'), array(':', ';', '='), $s);
}

static function params2str($params,$prefix='_='){
	if (self::$project_modules==NULL) self::getModules();
	$str = '';
	foreach ((array)$params as $module => $data){
		if (empty($data)) continue;
        $m = isset(module::$project_modules[$module]) ? module::$project_modules[$module] : $module;
        $str .= ";$m";
        foreach ($data as $k => $v)
            $str .= ':'.module::escapeParam($k).'='.module::escapeParam($v);
	}
	$str = param_str_compress(ltrim($str, ';'));
	return $prefix.$str;
}

function str2params($str){
	if (self::$project_modules==NULL) self::getModules();
	$str = param_str_decompress($str);
	$modules = explode(';', $str);
	$params = array();
	foreach ($modules as $d){
        $data = explode(':', $d);
        $m = array_shift($data);
        $module = array_search($m, module::$project_modules);
        if ($module===false) $module = $m;
        foreach ($data as $p){
        	list($k, $v) = explode('=', $p);
            $params[$module][module::unescapeParam($k)] = module::unescapeParam($v);
        }
	}
	return $params;
}

function redirect($params=array()){
    $p = array();
    if (is_object($this->owner)) $this->owner->collectParams($p);
    $p[$this->name] = $params;
    header("Location: ".SCRIPT_NAME.module::params2str($p));
    exit;
}

function checkInstalled() {
    if (!is_file(DIR_MODULES.$this->name."/installed")) $this->install();
    else {
        $rec = SQLSelectOne("SELECT * FROM project_modules WHERE NAME='{$this->name}'");
        if ($rec['id']) $this->install();
    }
}

function getConfig(){
    $rec = SQLSelectOne("SELECT * FROM project_modules WHERE NAME='{$this->name}'");
    $data = $rec['config'];
    $this->config = unserialize($data);
    return $this->config;
}

function saveConfig(){
    $rec = SQLSelectOne("SELECT * FROM project_modules WHERE NAME='{$this->name}'");
    $rec['config'] = serialize($this->config);
    SQLUpdate('project_modules', $rec);
}

function install($parent_name=''){
    $this->dbInstall('');
    $rec = SQLSelectOne("SELECT * FROM project_modules WHERE NAME='{$this->name}'");
    if (!$rec['id']){
    	$rec = array (
            'name' => $this->name,
            'title' => $this->title!='' ? $this->title : $this->name,
            'category' => $this->module_category!='' ? $this->module_category : 'CMS',
    	
    	);
        $rec['id'] = SQLInsert('project_modules', $rec);
    }
    if (!file_exists(DIR_MODULES.$this->name.'/installed'))
        file_put_contents(DIR_MODULES.$this->name.'/installed', date('H:m d.M.Y'));
}

function uninstall(){
    $rec = SQLSelectOne("SELECT * FROM project_modules WHERE NAME='{$this->name}'");
    if ($rec['id']) SQLExec("DELETE FROM project_modules WHERE ID='$rec[id]'");
    if (is_file(DIR_MODULES.$this->name.'/installed')) unlink(DIR_MODULES.$this->name.'/installed');
}

function dbInstall($data){
}

}
