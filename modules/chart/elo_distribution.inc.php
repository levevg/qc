<?php

    $width = 75;
    $elite = 2200;
    $group = "FLOOR(rating/$width)*$width";
    $min = SQLSelectVal("SELECT MIN($group) FROM leaderboard");
    $max = SQLSelectVal("SELECT MAX($group) FROM leaderboard");

    $duel = SQLSelectAssoc("SELECT $group AS `group`, COUNT(*) AS `count` FROM leaderboard WHERE gametype='duel' GROUP BY `group`", 'group');
    $tdm = SQLSelectAssoc("SELECT $group AS `group`, COUNT(*) AS `count` FROM leaderboard WHERE gametype='tdm' GROUP BY `group`", 'group');

    $out['width'] = 75;
    $out['duel'] = [];
    $out['tdm'] = [];
    $out['categories'] = [];
    $out['elite'] = $elite;
    $duelElite = 0;
    $tdmElite = 0;
    for ($g = $min; $g < $max; $g += $width) {
        if ($g < $elite) {
            $out['categories'][] = $g;
            $out['duel'][] = isset($duel[$g]) ? (int)$duel[$g]['count'] : 0;
            $out['tdm'][] = isset($tdm[$g]) ? (int)$tdm[$g]['count'] : 0;
        } else {
            $duelElite += isset($duel[$g]) ? (int)$duel[$g]['count'] : 0;
            $tdmElite += isset($tdm[$g]) ? (int)$tdm[$g]['count'] : 0;
        }
    }

    array_unshift($out['categories'], 'нет<br/>данных');
    array_unshift($out['duel'], 0);
    array_unshift($out['tdm'], 0);

    $out['categories'][] = 'Elite';
    $out['duel'][] = $duelElite;
    $out['tdm'][] = $tdmElite;
