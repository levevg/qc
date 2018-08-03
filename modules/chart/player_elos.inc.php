<?php

    $this->filtersByDate($out);

    $player = [];
    $tdm = chart::playersRating('tdm', $out['startDate'], $out['endDate'])[$this->id];
    $duel = chart::playersRating('duel', $out['startDate'], $out['endDate'])[$this->id];

    $minTimeTdm = $tdm ? min($tdm['ratings'][0][0], $tdm['deviations'][0][0]) : 2000000000000;
    $minTimeDuel = $duel ? min($duel['ratings'][0][0], $duel['deviations'][0][0]) : 2000000000000;
    $maxTimeTdm = time() * 1000; //$tdm ? max(end($tdm['ratings'])[0], end($tdm['deviations'])[0]) : null;
    $maxTimeDuel = time() * 1000; //$duel ? max(end($duel['ratings'])[0], end($duel['deviations'])[0]) : null;

    $chopFrom = min($minTimeDuel, $minTimeTdm);
    $chopTo = max($maxTimeDuel, $maxTimeTdm);

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