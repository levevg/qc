<div style="width: 100%; height: 100%; display: flex; align-items: center;">
    <div id="{$chart_id}" style="width: 700px; height: 700px; margin: 0 auto;"></div>
</div>
<script>
    let size = 600;
    var chart = {
        chart: { type: 'scatter', },
        title: { text: 'New rating vs Old rating' },
        xAxis: {
            title: { text: 'Before reset' },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true,
            gridLineWidth: 1,
            min: 600,
            max: 3000,
            width: size,
            height: size,
            tickInterval: 150,
            gridLineColor: 'rgba(120,120,120,0.15)',
            tickColor: 'rgba(120,120,120,0.15)',
            lineColor: 'rgba(120,120,120,0.15)',
        },
        yAxis: {
            title: { text: 'After reset' },
            min: 600,
            max: 3000,
            width: size,
            height: size,
            tickInterval: 150,
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true,
            gridLineWidth: 1,
            gridLineColor: 'rgba(120,120,120,0.15)',
            tickColor: 'rgba(120,120,120,0.15)',
            lineColor: 'rgba(120,120,120,0.15)',
        },
        plotOptions: {
            scatter: {
                marker: { radius: 2, },
                tooltip: {
                    headerFormat: '<span style="font-size:150%; font-weight: bold">{ldelim}point.key}</span> - <i>{ldelim}series.name}</i><br/>.<br/>',
                    pointFormat: 'Old: {ldelim}point.x}<br/>New: {ldelim}point.y}'
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'top',
            x: -30, y: 25,
            floating: true,
            backgroundColor: '#333',
        },
        series: [
            {
                name: 'Duel',
                data: {$duel|json_encode:32}
            },
            {
                name: '2v2',
                data: {$tdm|json_encode:32}
            }
        ]
    };
    Highcharts.chart('{$chart_id}', chart);
</script>