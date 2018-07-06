<?php

class chart extends module {

static $uid = 0;

static $game_types =
    array('DUEL' => 'Duel',
          'FFA' => 'FFA',
          'INSTAGIB' => 'Instagib',
          'SACRIFICE' => 'Sacrifice',
          'TDM' => 'TDM',
          'TDM_2VS2' => '2v2');

static $map_names =
    array('blood_covenant' => 'Blood Covenant',
          'ruins_of_sarnath' => 'Ruins Of Sarnath',
          'awoken' => 'Awoken',
          'corrupted_keep' => 'Corrupted Keep',
          'bloodrun' => 'Blood Run',
          'burial_chamber' => 'Burial Chamber',
          'church' => 'Church of Azathoth',
          'lighthouse' => 'Tempest Shrine',
          'vale_of_pnath' => 'Vale Of Pnath',
          'lockbox' => 'Lockbox',
          'fortress_of_the_deep' => 'The Molten Falls');

static function niceMapName($map_id) {
    return isset(chart::$map_names[$map_id]) ?
        chart::$map_names[$map_id] :
        ucwords(str_replace('_', ' ', $map_id));
}

static function playersRating($gametype) {
    static $cache = array();
    if (isset($cache[$gametype])) return $cache[$gametype];

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

    $cache[$gametype] = $players;
    return $players;
}

static function chopTimeSeries($series, $from_time, $to_time, $by = 3600000) {
    return $series;
}

function run(){
    ++chart::$uid;

    $out = array('chart_id' => $this->mode.'_'.chart::$uid);

    switch ($this->mode) {
        case 'matches_by_player':
            $this->matches_by_player($out);
            break;
        case 'matches_by_map':
            $this->matches_by_map($out);
            break;
        case 'player_elos':
            $this->player_elos($out);
            break;
        case 'combined_elo':
            $this->combined_elo($out, $this->gametype);
            break;
        case 'all_players_list_elos':
            $out['players'] = SQLSelect("SELECT * FROM players WHERE show_stats LIKE '%rating%'");
            break;
    }

    $this->data = $out;
}

function matches_by_map(&$out) {
    require 'matches_by_map.inc.php';
}

function matches_by_player(&$out) {
    require 'matches_by_player.inc.php';
}

function player_elos(&$out) {
    require 'player_elos.inc.php';
}

function combined_elo(&$out, $gametype) {
    require 'combined_elo.inc.php';
}

}