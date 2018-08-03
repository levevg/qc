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

static function playersRating($gametype, $startDate, $endDate) {
    static $cache = array();
    static $cacheHash = '';

    $startDate = '2001-01-01';
    $endDate = '2021-01-01';

    $hash = "$startDate $endDate";
    if (isset($cache[$gametype]) && $cacheHash == $hash) return $cache[$gametype];

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

    $startDate = mes($startDate);
    $endDate = mes($endDate);
    $filter_date = "time BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";

    $ratings = SQLSelect("SELECT player_id, UNIX_TIMESTAMP(time) AS x, num_value AS y FROM stats WHERE player_id IN ($ids) AND keypath_id='$ratingKeyId' AND $filter_date ORDER BY time");
    $deviations = SQLSelect("SELECT player_id, UNIX_TIMESTAMP(time) AS x, num_value AS y FROM stats WHERE player_id IN ($ids) AND keypath_id='$deviationKeyId' AND $filter_date ORDER BY time");

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
    $cacheHash = $hash;

    return $players;
}

function filtersByDate(&$out) {
    $startDate = $_REQUEST['startDate'] ?: date('Y-m-d', time() - 7*24*3600);
    $endDate = $_REQUEST['endDate'] ?: date('Y-m-d');
    //$out['startDate'] = $startDate;
    //$out['endDate'] = $endDate;
}

static function chopTimeSeries($series, $from_time, $to_time, $by = 3600000) {
    if (!count($series) || $from_time > $to_time) return [];

    $from_time = round($from_time / $by) * $by;
    $to_time = round($to_time / $by) * $by;
    foreach ($series as $i => $s) {
        $s[0] = round($s[0] / $by) * $by;
        $series[$i] = $s;
    }
    $result = [];
    $last = null;
    for ($time = $from_time; $time <= $to_time; $time += $by) {
        while (count($series) && $series[0][0] <= $time) {
            $last = array_shift($series);
        }
        if ($last) {
            $last[0] = $time;
            $result[] = $last;
        }
    }
    return $result;
}

function run(){
    ++chart::$uid;

    if (!$this->chart_id) $this->chart_id = $this->mode.'_'.chart::$uid;

    $out = array('chart_id' => $this->chart_id);

    startMeasure("chart::".$this->mode);

    $out['datepicker_format'] = 'YYYY-MM-DD';

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
        case 'elo_distribution':
            $this->elo_distribution($out);
            break;
        case 'players_matches':
            $this->players_matches($out);
            break;
        case 'elo_old_vs_new':
            $this->elo_old_vs_new($out);
            break;
        case 'all_players_list_elos':
            $out['players'] = SQLSelect("SELECT * FROM players WHERE show_stats LIKE '%rating%'");
            break;
    }

    $this->data = $out;

    endMeasure("chart::".$this->mode);
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

function elo_distribution(&$out) {
    require 'elo_distribution.inc.php';
}

function combined_elo(&$out, $gametype) {
    require 'combined_elo.inc.php';
}

function players_matches(&$out) {
    require 'players_matches.inc.php';
}

function elo_old_vs_new(&$out) {
    require 'elo_old_vs_new.inc.php';
}

}