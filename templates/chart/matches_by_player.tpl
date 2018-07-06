<div id="{$chart_id}" class="chart"></div>
<script>
    var chart = {
        chart: { type: 'column' },
        title: { text: '{$title}' },
        xAxis: { categories: {$gamescountPlayers|json_encode:32} },
        yAxis: {
            min: 0,
            title: { enabled: false },
            stackLabels: { enabled: true, }
        },
        legend: {
            align: 'right',
            verticalAlign: 'top',
            x: -30, y: 25,
            floating: true,
            backgroundColor: '#333',
        },
        tooltip: {
            headerFormat: '{ldelim}point.x}<br/>',
            pointFormat: '{ldelim}series.name}: {ldelim}point.y}<br/>',
            shared: true,
        },
        plotOptions: {
            column: { stacking: 'normal', }
        },
        series: {$gamescount|json_encode:32}
    };
    Highcharts.chart('{$chart_id}', chart);
</script>