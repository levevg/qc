<?php

    $player = [];
    $tdm = chart::playersRating('tdm')[$this->id];
    $duel = chart::playersRating('duel')[$this->id];

    if ($tdm) {
        $player = $tdm;
        $player['tdmRatings'] = $tdm['ratings'];
        $player['tdmDeviations'] = $tdm['deviations'];
        unset($player['ratings']);
        unset($player['deviations']);
    }
    if ($duel) {
        if (!$tdm) {
            $player = $duel;
        }
        $player['duelRatings'] = $duel['ratings'];
        $player['duelDeviations'] = $duel['deviations'];
        unset($player['ratings']);
        unset($player['deviations']);
    }

    $out['player'] = $player;