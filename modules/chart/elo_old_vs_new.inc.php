<?php

    $out['duel'] = SQLSelect("SELECT old.rating AS `x`, new.rating AS `y`, new.nickname AS name FROM leaderboard new JOIN leaderboard_before_reset old ON (new.nickname = old.nickname AND new.gametype = old.gametype) WHERE new.gametype = 'duel'");
    $out['tdm'] = SQLSelect("SELECT old.rating AS `x`, new.rating AS `y`, new.nickname AS name FROM leaderboard new JOIN leaderboard_before_reset old ON (new.nickname = old.nickname AND new.gametype = old.gametype) WHERE new.gametype = 'tdm'");