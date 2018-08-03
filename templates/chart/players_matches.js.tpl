{
    chart: {
        type: 'heatmap',
        marginTop: 45,
        marginBottom: 60,
    },
    title: { text: 'Задротометр' },
    exporting: { enabled: false },
    xAxis: { categories: {$days|json_encode:32} },
    yAxis: {
        categories: {$players|json_encode:32},
        title: null
    },
    colorAxis: {
        min: 0,
        minColor: 'rgba(0, 179, 176, 0)',
        maxColor: Highcharts.getOptions().colors[0]
    },
    legend: { enabled: false },
    tooltip: {
        formatter: function () {
            var games = 'игры';
            if ((this.point.value % 10 == 1) && (this.point.value != 11)) games = 'игру';
            if (this.point.value % 10 > 4 || (this.point.value>9 && this.point.value < 21)) games = 'игр';
            return this.series.xAxis.categories[this.point.x] + ' <b>' + this.series.yAxis.categories[this.point.y] + '</b> сыграл ' + this.point.value + ' ' + games;
        }
    },
    series: [{
        name: 'Матчи',
        borderWidth: 0,
        data: {$matches|json_encode:32},
        dataLabels: {
            enabled: true,
            color: '#FFFFFF'
        }
    }]
}