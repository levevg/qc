{
    exporting: { enabled: false },
    chart: { type: 'pie' },
    title: { text: '{$title}' },
    tooltip: {
        pointFormat: '{ldelim}series.name}: <b>{ldelim}point.y}</b>'
    },
    plotOptions: {
        pie: {
            borderColor: '#333',
            dataLabels: {
                enabled: true,
                format: '<b>{ldelim}point.name}</b>: {ldelim}point.percentage:.0f}%',
                style: { fontSize: '13px', },
            }
        }
    },
    series: [{
        name: 'Игр',
        data: {$maps|json_encode:32},
    }]
}