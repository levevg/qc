<?php

    $this->filtersByDate($out);

    $out['title'] = array('duel' => 'Дуэльный рейтинг', 'tdm' => 'Рейтинг в 2v2')[$gametype];

    $players = chart::playersRating($gametype, $out['startDate'], $out['endDate']);
    $maxTime = time() * 1000;
    foreach ($players as $i => $player) {
        if (count($player['ratings'])) {
            $players[$i]['ratings'] = chart::chopTimeSeries($player['ratings'], $player['ratings'][0][0], $maxTime);
        }
    }

    $out['players'] = $players;