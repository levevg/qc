<div id="{$chart_id}" class="chart"></div>
<script>
    var chart = {
        title: { text: '{$player.nickname}' },
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
            {
                name: 'Рейтинг в 2х2',
                data: {$player.tdmRatings|json_encode},
                zIndex: 1,
                marker: { lineWidth: 1 }
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
                marker: {  enabled: false  }
            },
            {
                name: 'Рейтинг в дуэлях',
                data: {$player.duelRatings|json_encode},
                zIndex: 1,
                marker: { lineWidth: 1 }
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
                marker: {  enabled: false  }
            },
        ]
    };
    Highcharts.chart('{$chart_id}', chart);
</script>