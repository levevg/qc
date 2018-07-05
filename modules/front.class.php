<?php

class front extends module {

var $no_install = true;
	
function run(){
	if ($this->action=='error404') error404();

    $out = array();

    $tdm = $this->playersDataWithRating('tdm');
    $duel = $this->playersDataWithRating('duel');
    $players = [];
    foreach ($duel as $id => $pl) {
        if (!isset($players[$id])) {
            $players[$id] = $pl;
        }
        $players[$id]['duelRatings'] = $pl['ratings'];
        $players[$id]['duelDeviations'] = $pl['deviations'];
        unset($players[$id]['ratings']);
        unset($players[$id]['deviations']);
    }
    foreach ($tdm as $id => $pl) {
        if (!isset($players[$id])) {
            $players[$id] = $pl;
        }
        $players[$id]['tdmRatings'] = $pl['ratings'];
        $players[$id]['tdmDeviations'] = $pl['deviations'];
        unset($players[$id]['ratings']);
        unset($players[$id]['deviations']);
    }
    $out['players'] = $players;

    $out['maps'] = SQLSelect("SELECT COUNT(*) AS y, o2.value AS name
FROM other_values o1 JOIN other_values o2 JOIN
    (SELECT s1.other_value AS matchIdValue, s2.other_value AS matchMapValue
    FROM stats s1 JOIN stats s2 JOIN
        (SELECT j1.id AS keyMatchId, j2.id AS keyMatchMap
        FROM json_keys j1 JOIN json_keys j2 ON (REPLACE(j1.keypath, '.id', '.mapName') = j2.keypath)
        WHERE j1.keypath LIKE 'games.matches.%.id') k
    ON s1.keypath_id = k.keyMatchId AND s1.time=s2.time AND s2.keypath_id = k.keyMatchMap
    GROUP BY matchIdValue, matchMapValue) m
ON o1.id = matchIdValue AND o2.id = matchMapValue
GROUP BY o2.value
ORDER BY y DESC");

    foreach ($out['maps'] as &$map) {
        $map['name'] = ucwords(str_replace('_', ' ', $map['name']));
    }

    $this->template = 'index.tpl';
    $this->data = $out;
}

    public function playersDataWithRating($gametype) {
        $ratingKeyId = SQLSelectVal("SELECT id FROM json_keys WHERE keypath='stats.playerRatings.$gametype.rating'");
        $deviationKeyId = SQLSelectVal("SELECT id FROM json_keys WHERE keypath='stats.playerRatings.$gametype.deviation'");
        $playersList = SQLSelect("SELECT * FROM players WHERE active=1 AND show_stats LIKE '%rating%'");
        $ids = [];
        $players = [];
        foreach ($playersList as $player) {
            $player['ratings'] = [];
            $player['deviations'] = [];
            $players[$player['id']] = $player;
            $ids[] = $player['id'];
        }
        $ids = implode(',', $ids);
        $ratings = SQLSelect("SELECT player_id, UNIX_TIMESTAMP(time) AS x, num_value AS y FROM stats WHERE player_id IN ($ids) AND keypath_id='$ratingKeyId' ORDER BY time");
        $deviations = SQLSelect("SELECT player_id, UNIX_TIMESTAMP(time) AS x, num_value AS y FROM stats WHERE player_id IN ($ids) AND keypath_id='$deviationKeyId' ORDER BY time");

        foreach ($ratings as $rating) {
            $players[$rating['player_id']]['ratings'][] = $rating;
        }
        foreach ($deviations as $deviation) {
            $players[$deviation['player_id']]['deviations'][] = $deviation;
        }
        foreach ($players as &$player) {
            $timeline = array();
            foreach ($player['ratings'] as $rating) {
                $timeline[$rating['x']]['r'] = $rating['y'];
            }
            foreach ($player['deviations'] as $deviation) {
                $timeline[$deviation['x']]['d'] = $deviation['y'];
            }
            $lastRating = null;
            $lastDeviation = null;
            foreach ($timeline as $i => $point) {
                if ($point['r']) $lastRating = $point['r'];
                else if ($lastRating != null) $timeline[$i]['r'] = $lastRating;
                if ($point['d']) $lastDeviation = $point['d'];
                else if ($lastDeviation != null) $timeline[$i]['d'] = $lastDeviation;
            }
            $player['ratings'] = array();
            $player['deviations'] = array();
            foreach ($timeline as $time => $p) {
                if ($p['r']) $player['ratings'][] = array($time * 1000, (int)$p['r']);
                if ($p['r'] && $p['d']) $player['deviations'][] = array($time * 1000, $p['r'] - $p['d'], $p['r'] + $p['d']);
            }
        }
        return $players;
    }

}
