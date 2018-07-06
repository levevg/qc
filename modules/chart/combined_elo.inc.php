<?php

    $out['title'] = array('duel' => 'Дуэльный рейтинг', 'tdm' => 'Рейтинг в 2v2')[$gametype];

    $players = chart::playersRating($gametype);
    $minTime = 2000000000000;
    $maxTime = time() * 1000;
    foreach ($players as $i => $player) {
        if (count($player['rating'])) $minTime = min($minTime, $player['rating'][0][0]);
    }
    $out['players'] = chart::chopTimeSeries($players, $minTime, $maxTime);