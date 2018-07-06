<div id="{$chart_id}" class="chart"></div>
<script>
    var chart = {
        title: { text: '{$player.nickname}' },
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
        legend: { enabled: false },
        plotOptions: {
            series: {
                marker: { enabled: false, states: { hover: { enabled: false } } },
            }
        },
        series: [
            {
                name: 'Рейтинг в 2х2',
                data: {$player.tdmRatings|json_encode},
                zIndex: 1,
            }, {
                name: 'С вероятностью 68% между',
                data: {$player.tdmDeviations|json_encode},
                type: 'arearange',
                lineWidth: 1,
                dashStyle: 'Dot',
                linkedTo: ':previous',
                color: Highcharts.getOptions().colors[0],
                fillOpacity: 0.05,
                zIndex: 0,
            },
            {
                name: 'Рейтинг в дуэлях',
                data: {$player.duelRatings|json_encode},
                zIndex: 1,
            }, {
                name: 'С вероятностью 68% между',
                data: {$player.duelDeviations|json_encode},
                type: 'arearange',
                lineWidth: 1,
                dashStyle: 'Dot',
                linkedTo: ':previous',
                color: Highcharts.getOptions().colors[1],
                fillOpacity: 0.05,
                zIndex: 0,
            },
        ]
    };
    Highcharts.chart('{$chart_id}', chart);
</script>