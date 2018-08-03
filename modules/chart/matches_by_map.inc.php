<?php

    $out['title'] = 'Карты по популярности';

    if (!IS_AJAX) {
        $out['maps'] = array();
        return;
    }

    $query =
        "SELECT COUNT(*) AS y, o2.value AS name
            FROM other_values o1 JOIN other_values o2 JOIN
                (SELECT s1.other_value AS matchIdValue, s2.other_value AS matchMapValue
                FROM stats s1 JOIN stats s2 JOIN
                    (SELECT j1.id AS keyMatchId, j2.id AS keyMatchMap
                    FROM json_keys j1 JOIN json_keys j2 ON (REPLACE(j1.keypath, '.id', '.mapName') = j2.keypath)
                    WHERE j1.keypath LIKE 'games.matches.%.id') k
                ON s1.keypath_id = k.keyMatchId AND s1.revision=s2.revision AND s2.keypath_id = k.keyMatchMap AND s1.player_id=s2.player_id
                GROUP BY matchIdValue, matchMapValue) m
            ON o1.id = matchIdValue AND o2.id = matchMapValue
            GROUP BY o2.value
            ORDER BY y DESC";

    $maps = SQLSelect($query);

    foreach ($maps as $k => $map) {
        $maps[$k]['name'] = chart::niceMapName($maps[$k]['name']);
    }

    $out['maps'] = $maps;