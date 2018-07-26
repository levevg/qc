<?php

include_once("./config.php");
include_once("./include/errors.php");
include_once("./include/autoload.php");
dbConnect(DB_HOST, DB_NAME, DB_USER, DB_PASS);
settings::load();

$duelUpdateRange = SQLSelect("SELECT * FROM leaderboard_ranges WHERE gametype='duel' ORDER BY last_updated, RAND() ASC LIMIT 1");
$tdmUpdateRange = SQLSelect("SELECT * FROM leaderboard_ranges WHERE gametype='tdm' ORDER BY last_updated, RAND() ASC LIMIT 1");
$rangesToUpdate = array_merge($duelUpdateRange, $tdmUpdateRange);
foreach ($rangesToUpdate as $range) {
    $from = $range[range_from];
    echo "Updating $range[gametype] leaderboard range $range[range_from]-".($from+99)."\n";
    $path = "https://stats.quake.com/api/v2/Leaderboard?board=$range[gametype]&from=$from";
    $json = @json_decode(file_get_contents($path), true);
    $entries = $json['entries'];
    SQLExec("DELETE FROM leaderboard WHERE gametype='$range[gametype]' AND idx BETWEEN $from AND ".($from+count($entries)-1));
    $values = [];
    foreach ($entries as $i => $player) {
        $values[] = "(\"".mes($player['userName'])."\", $player[eloRating], ".($i + $from).", \"$range[gametype]\")";
    }
    $sql = "INSERT INTO leaderboard (nickname, rating, idx, gametype) VALUES \n".implode(",\n", $values);
    SQLExec($sql);
    SQLExec("UPDATE leaderboard_ranges SET last_updated=CURRENT_TIMESTAMP() WHERE id=".$range['id']);
}

dbDisconnect();
