<div id="{$chart_id}" class="chart"></div>
<script>
    var chart = {
        title: { text: '{$title}' },
        xAxis: { type: 'datetime' },
        yAxis: {
            title: { text: null },
            softMin: 0,
            softMax: 2500,
            gridLineWidth: 0,
            plotBands: ratingPlotBands,
            plotLines: ratingPlotLines,
        },
        tooltip: { crosshairs: true, shared: true, },
        legend: { enabled: false },
        series: [
            {foreach from=$players item=player}
            {
                name: '{$player.nickname}',
                data: {$player.ratings|json_encode},
                zIndex: 1,
                marker: { enabled: false }
            },
            {/foreach}
        ]
    };
    Highcharts.chart('{$chart_id}', chart);
</script>