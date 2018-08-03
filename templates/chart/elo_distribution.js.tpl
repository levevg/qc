{
    title: { text: 'Распределение рейтинга' },
    exporting: { enabled: false },
    chart: { type: 'area' },
    xAxis: {
        allowDecimals: false,
        categories: {$categories|json_encode:32},
    },
    yAxis: {
        title: {  enabled: false },
    },
    legend: {
        align: 'right',
        verticalAlign: 'top',
        x: -30, y: 25,
        floating: true,
        backgroundColor: '#333',
    },
    tooltip: {
        crosshairs: true,
        shared: true,
        formatter: eloDistributionTooltipFormatter,
    },
    plotOptions: {
        area: { marker: { enabled: false, states: { hover: { enabled: false } } } },
    },
    series: [{
        name: 'Дуэли',
        data: {$duel|json_encode:32},
        fillOpacity: 0.3,
    },
    {
        name: '2v2',
        data: {$tdm|json_encode:32},
        fillOpacity: 0.2,
    }]
}