<div id="{$chart_id}" class="chart"></div>
<script>
    function tooltipFormatter() {
        if (this.x=='Elite') return 'Группа <b>{$elite}+' +
            '</b><br/>Дуэли: <b>' + this.points[0].y + '</b> игроков<br/>2v2: <b>' + this.points[1].y + '</b> игроков';
        if (!parseInt(this.x)) return 'Инфа доступна только<br/>по топ-5000';
        return 'Группа <b>' + this.x + '-' + (this.x+74) +
            '</b><br/>Дуэли: <b>' + this.points[0].y + '</b> игроков<br/>2v2: <b>' + this.points[1].y + '</b> игроков';
    }

    var chart = {
        title: { text: 'Распределение рейтинга' },
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
            formatter: tooltipFormatter,
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
    };
    Highcharts.chart('{$chart_id}', chart);
</script>