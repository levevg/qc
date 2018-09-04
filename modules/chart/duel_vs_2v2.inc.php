<?php

    function regression($data) {
        $ss = 0; $s = 0;
        $k = 0; $b = 0;
        $n = count($data);
        foreach ($data as $d) {
            $ss += $d['x'] * $d['x'];
            $s += $d['x'];
        }
        foreach ($data as $d) {
            $k += ($ss - $s * $d['x']) * $d['y'];
            $b += (-$s + $n * $d['x']) * $d['y'];
        }
        $det = $n * $ss - $s * $s;
        return [$b/$det, $k/$det];
    }

    $elo = SQLSelect("SELECT duel.rating AS `x`, tvt.rating AS `y`, new.nickname AS name FROM leaderboard duel JOIN leaderboard tvt ON (duel.nickname = tvt.nickname AND duel.gametype = \"duel\" AND tvt.gametype=\"tdm\")");

    $out['elo'] = $elo;
    list($out['elo_slope'], $out['elo_offset']) = regression($elo);
