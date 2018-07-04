<?php

	function fail($error, $file, $line){
		ob_clean();
		if (is_array($error)) $error = implode('<br />', $error);
		echo "$error<br />$file:$line";
		die;
	}