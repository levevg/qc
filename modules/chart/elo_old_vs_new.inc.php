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

    $duel = SQLSelect("SELECT old.rating AS `x`, new.rating AS `y`, new.nickname AS name FROM leaderboard new JOIN leaderboard_before_reset old ON (new.nickname = old.nickname AND new.gametype = old.gametype) WHERE new.gametype = 'duel'");
    $tdm = SQLSelect("SELECT old.rating AS `x`, new.rating AS `y`, new.nickname AS name FROM leaderboard new JOIN leaderboard_before_reset old ON (new.nickname = old.nickname AND new.gametype = old.gametype) WHERE new.gametype = 'tdm'");;

    $out['duel'] = $duel;
    list($out['duel_slope'], $out['duel_offset']) = regression($duel);

    $out['tdm'] = $tdm;
    list($out['tdm_slope'], $out['tdm_offset']) = regression($tdm);
