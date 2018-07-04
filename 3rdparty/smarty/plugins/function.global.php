<?php

function smarty_function_global($params, &$smarty){
	return "{global var=$params[var]}";
}