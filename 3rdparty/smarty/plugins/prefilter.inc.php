<?php

function smarty_prefilter_inc($source, $smarty){
    return preg_replace('/\{inc file="(.+?)"}/', '{include file="{$smarty.current_dir}/\\1"}', $source);
}