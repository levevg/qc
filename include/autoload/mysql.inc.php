<?php

	global $dbLink;
	
	function dbConnect($host, $name, $user, $password){
		if (isset($dbLink)) return null;
		$dbLink = @mysqli_connect($host, $user, $password);
		if ($dbLink){
			@mysqli_select_db($dbLink, $name) || fail(array("Couldn't select database `$name`", implode(' ', mysqli_error_list($dbLink))), __FILE__, __LINE__);
			if (defined('MYSQL_CHARSET'))  mysqli_query($dbLink, "SET NAMES '".MYSQL_CHARSET."'");
			if (defined('MYSQL_CHARSET'))  mysqli_query($dbLink, "SET NAMES '".MYSQL_CHARSET."'");
			$GLOBALS['dbLink'] = $dbLink;
		} else {
			fail(array("Couldn't connect to MySQL server", mysqli_error($dbLink)), __FILE__, __LINE__);
		}
		return $dbLink;
	}
	
	function dbDisconnect(){
		global $dbLink;
		if ($dbLink) mysqli_close($dbLink);
	}
	
	function dbEscape($str){
	    global $dbLink;
		return mysqli_escape_string($dbLink, $str);
	}
	
	function SQLError($text='', $file='', $line=''){
		global $dbLink;
		if (defined('FAIL_ON_SQL_ERROR') && FAIL_ON_SQL_ERROR) fail(array("SQLError", mysqli_error($dbLink), $text), $file, $line);
	}
	
	function SQLExec($query){
		global $dbLink;
		$result = @mysqli_query($dbLink, $query);
		if (!$result){
			SQLError();
			return false;
		}
		return $result;
	}
	
	function SQLSelect($query){
		global $dbLink;
		$result = mysqli_query($dbLink, $query);
		if ($result){
			$res = array();
			while ($rec = mysqli_fetch_assoc($result))
				$res[] = $rec;
			return $res;
		} else {
			SQLError();
			return false;
		}
	}

	function SQLSelectOne($query){
		global $dbLink;
		$result = mysqli_query($dbLink, $query);
		if ($result){
			$rec = mysqli_fetch_assoc($result);
			return $rec ? $rec : false;
		} else {
			SQLError();
		}
	}
	
	function SQLSelectVal($query){
		global $dbLink;
		$result = mysqli_query($dbLink, $query);
		if ($result){
			$rec = mysqli_fetch_assoc($result);
			return $rec ? @current($rec) : false;
		} else {
			SQLError();
		}
	}
	
	function SQLUpdate($table, $rec, $key = "id"){
		global $dbLink;
		if (!isset($rec[$key])) return false;
		$query = "UPDATE `$table` SET ";
		$fields = array ();
		foreach($rec as $k => $v)
			$fields[] = "`$k` = ".($v===null?'NULL' : "\"".dbEscape($v)."\"");
		if (!count($fields)) return false;
		$query .= implode(",\n", $fields);
		$query .= " WHERE `$key` = \"".dbEscape($rec[$key])."\"";
		if (!mysqli_query($dbLink, $query)){
			SQLError();
			return false;
		}
		return mysqli_affected_rows($dbLink);
	}

	function SQLInsert($table, $rec, $options = ""){
	    
		global $dbLink;
		$query = "INSERT $options INTO `$table` SET ";
		$fields = array ();
		foreach($rec as $k => $v)
			$fields[] = "`$k` = ".($v===null?'NULL' : "\"".dbEscape($v)."\"");
		if (!count($fields)) return false;
		$query .= implode(",\n", $fields);
		if (!mysqli_query($dbLink, $query)){
			SQLError();
			return false;
		}
		return mysqli_insert_id($dbLink);
	}

	function SQLSelectAssoc($query, $key) {
	    $rows = SQLSelect($query);
	    $result = [];
	    foreach ($rows as $row) {
	        $result[$row[$key]] = $row;
        }
        return $result;
    }