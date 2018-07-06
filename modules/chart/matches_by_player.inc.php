<?php

    $out['title'] = 'Сыграно матчей';

    $query =
        "SELECT players.nickname, player_id, mode, SUM(won+lost+tie) AS games
            FROM games_count JOIN players ON (games_count.player_id = players.id)
            WHERE players.show_stats LIKE '%gamecount%'
            GROUP BY mode, player_id";

    $gamescount = SQLSelect($query);

    $p = []; $g = [];
    foreach ($gamescount as $gc) {
        $p[$gc['player_id']] = $gc['nickname'];
        $g[$gc['player_id'].$gc['mode']] = $gc['games'];
    }
    $out['gamescountPlayers'] = array_values($p);

    $out['gamescount'] = [];
    foreach (chart::$game_types as $key => $name) {
        $data = [];
        foreach ($p as $id => $pl) {
            $data[] = $g[$id.$key];
        }
        $out['gamescount'][] = array('name' => $name, 'data' => $data);
    }