<div id="{$chart_id}" class="chart"></div>
<script>
    var chart = {
        title: { text: '{$title}' },
        xAxis: { type: 'datetime' },
        yAxis: {
            title: { text: null },
            softMin: 500,
            softMax: 2000,
            gridLineWidth: 0,
            plotBands: ratingPlotBands,
            plotLines: ratingPlotLines,
        },
        tooltip: { crosshairs: true, shared: true, },
        legend: {
            align: 'right',
            verticalAlign: 'top',
            x: -30, y: 25,
            floating: true,
            backgroundColor: '#333',
        },
        plotOptions: {
            series: {
                marker: { enabled: false, states: { hover: { enabled: false } } },
            }
        },
        series: [
            {foreach from=$players item=player}
            {
                name: '{$player.nickname}',
                data: {$player.ratings|json_encode},
                zIndex: 1,
            },
            {/foreach}
        ]
    };
    Highcharts.chart('{$chart_id}', chart);
</script>