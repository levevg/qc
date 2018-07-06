{if $mode == "matches_by_map"}
    {inc file="matches_by_map.tpl"}
{/if}

{if $mode == "matches_by_player"}
    {inc file="matches_by_player.tpl"}
{/if}

{if $mode == "player_elos"}
    {inc file="player_elos.tpl"}
{/if}

{if $mode == "combined_elo"}
    {inc file="combined_elo.tpl"}
{/if}

{if $mode == "all_players_list_elos"}
    {foreach from=$players item=player}
        {module name=chart mode=player_elos id=$player.id}
    {/foreach}
{/if}
