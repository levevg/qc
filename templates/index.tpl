<!DOCTYPE html>
<html>
<head>
    <title>{global var=page_title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="icon" type="image/png" href="/img/favicon-32x32.png" sizes="32x32"/>
    <link rel="icon" type="image/png" href="/img/favicon-96x96.png" sizes="96x96"/>
    <link rel="icon" type="image/png" href="/img/android-chrome-192x192.png" sizes="192x192"/>
    <link rel="icon" type="image/png" href="/img/favicon-16x16.png" sizes="16x16"/>
    <link rel="mask-icon" href="/img/safari-pinned-tab.svg" color="#5bbad5"/>
    <link rel="shortcut icon" href="/img/favicon.ico"/>
    <link href="/combine.php?files=css%2Fstyle.css" rel="stylesheet" type="text/css" />
    <script src="https://code.highcharts.com/highcharts.src.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script type="text/javascript" src="/combine.php?files=js%2Fjquery.js,js%2Fscripts.js"></script>
</head>
<body>
<div style="width:50%;float:left">
    <div id="gamescount" class="chart"></div>
    <div id="pop_maps" class="chart"></div>
</div>
<div style="width:50%;float:left">
{foreach from=$players item=player}<div id="tdm_elo_{$player.id}" class="chart"></div>{/foreach}
</div>
<script>
    Highcharts.chart('pop_maps', {
    chart: { type: 'pie' },
    title: {
        text: 'Карты по популярности'
    },
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
});

Highcharts.chart('gamescount', {
    chart: { type: 'column' },
    title: { text: 'Сыграно матчей' },
    xAxis: {
        categories: {$gamescountPlayers|json_encode:32}
    },
    yAxis: {
        min: 0,
        title: { enabled: false },
        stackLabels: {
            enabled: true,
        }
    },
    legend: {
        align: 'right',
        verticalAlign: 'top',
        x: -30,
        y: 25,
        floating: true,
        backgroundColor: '#333',
    },
    tooltip: {
        headerFormat: '{ldelim}point.x}<br/>',
        pointFormat: '{ldelim}series.name}: {ldelim}point.y}<br/>',
        shared: true,
    },
    plotOptions: {
        column: {
            stacking: 'normal',
        }
    },
    series: {$gamescount|json_encode:32}
});

</script>
{foreach from=$players item=player}
<script>
    Highcharts.chart('tdm_elo_{$player.id}', {
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
    });
</script>
{/foreach}
</body>
</html>
