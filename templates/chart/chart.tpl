{if $mode == "all_players_list_elos"}
    {foreach from=$players item=player}
        {module name=chart mode=player_elos id=$player.id}
    {/foreach}
{else}

    {if !$ajax}
        <div class="chart_toolbar_container">
            <div class="chart_toolbar">
            {if $startDate}
                Фильтровать по дате: <input type="text" class="date" id="{$chart_id}_daterange" title="Временной промежуток"/>
            {/if}
            </div>
        </div>
        <div id="{$chart_id}" class="chart {$mode}"></div>

        <script>
        {if $startDate}
            $('#{$chart_id}_daterange').daterangepicker({
                "startDate": "{$startDate}", "endDate": "{$endDate}",
                "minDate": "2018-07-03", "maxDate": "{"Y-m-d"|date}",
                "locale": {
                    "format": "{$datepicker_format}",
                    "separator": " — ",
                    "applyLabel": "Ок",
                    "cancelLabel": "Отмена",
                    "fromLabel": "С",
                    "toLabel": "До",
                    "daysOfWeek": [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ],
                    "monthNames": [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
                                    "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
                    "firstDay": 1
                },
            }, function(start, end, label) {
                reloadChart('{$chart_id}', {$chart_id}, "{_ mode=$mode id=$id chart_id=$chart_id}&ajax=chart&startDate=" + start.format("{$datepicker_format}") + "&endDate=" + end.format("{$datepicker_format}"));
            });
        {/if}
    {/if}

        {if $mode == "matches_by_player"}
            var {$chart_id}_data = {inc file="matches_by_player.js.tpl"};
        {/if}

        {if $mode == "matches_by_map"}
            var {$chart_id}_data = {inc file="matches_by_map.js.tpl"};
        {/if}

        {if $mode == "player_elos"}
            var {$chart_id}_data = {inc file="player_elos.js.tpl"};
        {/if}

        {if $mode == "combined_elo"}
            var {$chart_id}_data = {inc file="combined_elo.js.tpl"};
        {/if}

        {if $mode == "elo_distribution"}
            var {$chart_id}_data = {inc file="elo_distribution.js.tpl"};
        {/if}

        {if $mode == "elo_old_vs_new"}
            let eonSize = 600, eonMinElo = 600, eonMaxElo = 3000;
            var {$chart_id}_data = {inc file="elo_old_vs_new.js.tpl"};
        {/if}

        {if $mode == "players_matches"}
            var {$chart_id}_data = {inc file="players_matches.js.tpl"};
        {/if}

    {if !$ajax}
            var {$chart_id} = Highcharts.chart('{$chart_id}', {$chart_id}_data);

            {if $mode == "matches_by_map"}
            $(function() { reloadChart('{$chart_id}', {$chart_id}, "{_ mode=$mode chart_id=$chart_id}&ajax=chart"); });
            {/if}
        </script>
    {/if}

{/if}