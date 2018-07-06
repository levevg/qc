<div id="{$chart_id}" class="chart"></div>
<script>
    var chart = {
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
    };
    Highcharts.chart('{$chart_id}', chart);
</script>