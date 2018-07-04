<?php

function smarty_function_module($params, &$smarty){
    if (!class_exists($params['name']) && is_file(DIR_MODULES."$params[name]/$params[name].class.php"))
        include_once DIR_MODULES."$params[name]/$params[name].class.php";
    
    if (!class_exists($params['name']))
        return "module $params[name] not found";
        
    $class = $params['name'];
    unset($params['name']);
    $params = array_map('htmlspecialchars_decode', $params);
    $module = new $class($params);
    $module->owner = $smarty->module;
        
    return $module->execute();
}