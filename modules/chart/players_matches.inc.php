<?php

    $players = SQLSelect("SELECT * FROM players WHERE show_stats LIKE '%day_matches%' ORDER BY id DESC");
    $matches = SQLSelect("SELECT DATE_FORMAT(time, '%w %e.%c.%Y') AS day, player_id, COUNT(*) AS matches FROM `player_matches` WHERE time > CURRENT_TIMESTAMP() - INTERVAL 14 DAY GROUP BY day, player_id ORDER BY time");
    $playerIndex = [];
    $out['players'] = [];
    foreach ($players as $player) {
        $playerIndex[$player['id']] = count($out['players']);
        $out['players'][] = $player['nickname'];
    }

    function formatDay($day) {
        $day = preg_replace_callback('/\.(\d+)\.20../', function($m){ return ' '.$GLOBALS['monthes'][$m[1]]; }, $day);
        $day = preg_replace_callback('/^(\d)/', function ($m){ return $GLOBALS['weekdays'][$m[1]];}, $day);
        return $day;
    }

    $out['days'] = [];
    $daysIndex = [];
    foreach ($matches as $k => $match) {
        $day = formatDay($match['day']);
        $matches[$k]['day'] = $day;
        if (!isset($daysIndex[$day])) {
            $daysIndex[$day] = count($out['days']);
            $out['days'][] = $day;
        }
    }

    $out['matches'] = [];
    foreach ($matches as $match) {
        $out['matches'][] = array($daysIndex[$match['day']], $playerIndex[$match['player_id']], $match['matches']);
    }