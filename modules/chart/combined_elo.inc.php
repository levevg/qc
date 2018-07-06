<?php

    $out['title'] = array('duel' => 'Дуэльный рейтинг', 'tdm' => 'Рейтинг в 2v2')[$gametype];

    $out['players'] = chart::playersRating($gametype);