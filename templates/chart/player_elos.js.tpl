{
    title: { text: '{$player.nickname}' },
    exporting: { enabled: false },
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
}