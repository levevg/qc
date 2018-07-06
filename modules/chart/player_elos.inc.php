<?php

    $player = [];
    $tdm = chart::playersRating('tdm')[$this->id];
    $duel = chart::playersRating('duel')[$this->id];

    $minTimeTdm = $tdm ? min($tdm['ratings'][0][0], $tdm['deviations'][0][0]) : null;
    $minTimeDuel = $duel ? min($duel['ratings'][0][0], $duel['deviations'][0][0]) : null;
    $maxTimeTdm = $tdm ? max(end($tdm['ratings'])[0], end($tdm['deviations'])[0]) : null;
    $maxTimeDuel = $duel ? max(end($duel['ratings'])[0], end($duel['deviations'])[0]) : null;

    echo "[$minTimeTdm, $maxTimeTdm] [$maxTimeTdm, $maxTimeDuel]<br/>";

    $chopFrom = 0;
    $chopTo = 0;

    if ($tdm) {
        $player = $tdm;
        $player['tdmRatings'] = chart::chopTimeSeries($tdm['ratings'], $chopFrom, $chopTo);
        $player['tdmDeviations'] = chart::chopTimeSeries($tdm['deviations'], $chopFrom, $chopTo);
        unset($player['ratings']);
        unset($player['deviations']);
    }
    if ($duel) {
        if (!$tdm) {
            $player = $duel;
        }
        $player['duelRatings'] = chart::chopTimeSeries($duel['ratings'], $chopFrom, $chopTo);
        $player['duelDeviations'] = chart::chopTimeSeries($duel['deviations'], $chopFrom, $chopTo);
        unset($player['ratings']);
        unset($player['deviations']);
    }

    $out['player'] = $player;