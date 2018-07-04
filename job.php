<?php

    include_once("./config.php");
    include_once("./include/errors.php");
    include_once("./include/autoload.php");
    dbConnect(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    settings::load();

    function loadStatsForNickname($nick) {
        $stats = loadJsonForNickname($nick, 'Stats');
        $games = loadJsonForNickname($nick, 'GamesSummary');
        return array("stats" => $stats, "games" => $games);
    }

    function loadJsonForNickname($nick, $kind) {
        $path = "https://stats.quake.com/api/v2/Player/$kind?name=".urlencode($nick);
        $contents = file_get_contents($path);
        $json = json_decode($contents, true);
        return $json;
    }

    function flattenJson($json, $prefix = "") {
        $result = [];
        foreach ($json as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, flattenJson($value, "$prefix$key."));
            } else {
                $result["$prefix$key"] = $value;
            }
        }
        return $result;
    }

    $maxKeyId = SQLSelectVal("SELECT MAX(id) FROM json_keys") + 1;
    $existingKeys = loadExistingKeys();
    $newKeys = [];

    function loadExistingKeys() {
        $json_keys = SQLSelect("SELECT * FROM json_keys");
        $existingKeys = [];
        foreach ($json_keys as $key) {
            $existingKeys[$key["keypath"]] = $key["id"];
        }
        return $existingKeys;
    }

    function keyIdForPath($path, &$existingKeys, &$newKeys, &$maxKeyId) {
        if (isset($existingKeys[$path])) {
            return $existingKeys[$path];
        } else {
            ++$maxKeyId;
            $existingKeys[$path] = $maxKeyId;
            $newKeys[$path] = $maxKeyId;
            return $maxKeyId;
        }
    }

    $maxOtherValueId = SQLSelectVal("SELECT MAX(id) FROM other_values") + 1;
    $existingOtherValues = loadLatestExistingOtherValues();
    $newOtherValues = [];

    function loadLatestExistingOtherValues()
    {
        $values = SQLSelect("SELECT * FROM `other_values` ORDER BY id DESC LIMIT 5000");
        $existingOtherValues = [];
        foreach ($values as $val) {
            $existingOtherValues[$val["value"]] = $val["id"];
        }
        $existingOtherValues[""] = 0;
        return $existingOtherValues;
    }

    function otherValueIdForValue($value, &$existingOtherValues, &$newOtherValues, &$maxOtherValueId) {
        if (isset($existingOtherValues[$value])) {
            return $existingOtherValues[$value];
        } else {
            ++$maxOtherValueId;
            $existingOtherValues[$value] = $maxOtherValueId;
            $newOtherValues[$value] = $maxOtherValueId;
            return $maxOtherValueId;
        }
    }

    function saveNewKeys() {
        global $newKeys;
        if (count($newKeys)) {
            $newRows = [];
            foreach ($newKeys as $key => $value) {
                $newRows[] = "($value, \"".mes($key)."\")";
            }
            $sql = "INSERT INTO json_keys (id, keypath) VALUES \n".
                    implode(",\n", $newRows);
            SQLExec($sql);
        }
        $newKeys = [];
    }

    function saveNewOtherValues() {
        global $newOtherValues;
        if (count($newOtherValues)) {
            $newRows = [];
            foreach ($newOtherValues as $key => $value) {
                $newRows[] = "($value, \"".mes($key)."\")";
            }
            $sql = "INSERT INTO other_values (id, value) VALUES \n".
                implode(",\n", $newRows);
            SQLExec($sql);
        }
        $newOtherValues = [];
    }

    function convertValue($value, &$num_value, &$time_value) {
        $num_value = null;
        $time_value = null;
        if ($value=="-62135596800000") { // timestamp for "never"
            $time_value = 0;
        } else
        if (strlen($value) == 13 && preg_match("/^\d+$/", $value)) { // timestamp in ms. Round to s.
            $time_value = round($value/1000);
        } else
        if (strlen($value) == 10 && preg_match("/^\d+$/", $value)) { // timestamp in s. Leave as is.
            $time_value = $value;
        } else
        if (is_numeric($value) && preg_match("/^-?\d+$/", $value)) { // integer number
            $num_value = $value;
        } else
        if (is_numeric($value)) { // floating number. Convert to a ratio
            $time_value = 1;
            $num_value = $value;
            $max = 1000000000;
            while (abs($num_value*10) < $max && $time_value*10 <= $max) {
                $num_value *= 10;
                $time_value *= 10;
            }
            $num_value = round($num_value);
        } else
        if (substr($value, 0, 2) == "20" && $value[4] == "-") {
            $time_value = strtotime($value);
        } else {
            return false;
        }
        return true;
    }

    function lastestStatsForPlayerId($player_id) {
        $sel = SQLSelect("SELECT s1.* FROM stats s1 JOIN (SELECT MAX(time) AS maxtime, keypath_id FROM stats WHERE player_id=$player_id GROUP BY keypath_id) s2 ON (s1.keypath_id=s2.keypath_id AND s1.time=s2.maxtime AND s1.player_id=$player_id)");
        $stats = [];
        foreach ($sel as $key => $val) {
            $stats[$val["keypath_id"]] = $val;
        }
        return $stats;
    }

    function nullToNullStr($v) {
        return $v == NULL ? "NULL" : $v;
    }

    $players = SQLSelect("SELECT players.*, CURRENT_TIMESTAMP() - last_updated AS passed ".
                         "FROM players WHERE active=1 "
                         ."HAVING passed > 3500 "
                        );

    foreach ($players as $player) {
        echo $player["nickname"]."\n";
        $json = loadStatsForNickname($player["nickname"]);
        $flat = flattenJson($json);
        $stats = lastestStatsForPlayerId($player["id"]);
        $newRows = [];
        foreach ($flat as $key => $value) {
            $keyId = keyIdForPath($key, $existingKeys, $newKeys, $maxKeyId);
            $num_value = null;
            $time_value = null;
            $other_value = null;
            if (!convertValue($value, $num_value,$time_value)) {
                $other_value = otherValueIdForValue($value,$existingOtherValues, $newOtherValues,$maxOtherValueId);
            }
            $prev = $stats[$keyId];
            if (!$prev["id"] || $prev["num_value"] != $num_value || $prev["other_value"] != $other_value || $prev["time_value"] != $time_value) {
                $num_value = nullToNullStr($num_value);
                $time_value = nullToNullStr($time_value);
                $other_value = nullToNullStr($other_value);
                $newRows[] = "($keyId,$player[id],$num_value,$other_value,$time_value)";
            }
        }
        $sql = "INSERT INTO stats (keypath_id, player_id, num_value, other_value, time_value) VALUES \n".
                implode(",\n", $newRows);
        saveNewKeys();
        saveNewOtherValues();
        if (count($newRows)) SQLExec($sql);
        SQLExec("UPDATE players SET last_updated=CURRENT_TIMESTAMP() WHERE id=$player[id]");
    }

    $sql = rtrim($sql, ",\n");

    dbDisconnect();
