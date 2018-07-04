<!DOCTYPE html>
<html>
<head>
    <title>{global var=page_title}</title>
    <meta name="keywords" content="{global var=meta_keywords}"/>
    <meta name="description" content="{global var=meta_description}"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="google-site-verification" content="" />
    <link rel="icon" type="image/png" href="/img/favicon-32x32.png" sizes="32x32"/>
    <link rel="icon" type="image/png" href="/img/favicon-96x96.png" sizes="96x96"/>
    <link rel="icon" type="image/png" href="/img/android-chrome-192x192.png" sizes="192x192"/>
    <link rel="icon" type="image/png" href="/img/favicon-16x16.png" sizes="16x16"/>
    <link rel="mask-icon" href="/img/safari-pinned-tab.svg" color="#5bbad5"/>
    <link rel="shortcut icon" href="/img/favicon.ico"/>
    <link href="/combine.php?files=style.css" rel="stylesheet" type="text/css" />
    <script src="https://code.highcharts.com/highcharts.src.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script type="text/javascript" src="/combine.php?files=js%2Fjquery.js,js%2Fscripts.js"></script>
</head>
<body>
<div style="width:50%;float:left">
{foreach from=$players item=player}<div id="tdm_elo_{$player.id}" class="chart"></div>{/foreach}
</div><div style="width:50%;float:left">
    <div id="pop_maps" class="chart"></div>
</div>
<script>
var ratingPlotBands = [
                { from: 600, to: 675, color: 'rgba(255, 150, 0, 0.05)', },
                { from: 675, to: 750, color: 'rgba(255, 150, 0, 0.09)', },
                { from: 750, to: 825, color: 'rgba(255, 150, 0, 0.13)', },
                { from: 825, to: 900, color: 'rgba(255, 150, 0, 0.17)', },
                { from: 900, to: 975, color: 'rgba(255, 150, 0, 0.21)', },

                { from: 975, to: 1050, color: 'rgba(255, 255, 255, 0.05)', },
                { from: 1050, to: 1125, color: 'rgba(255, 255, 255, 0.09)', },
                { from: 1125, to: 1200, color: 'rgba(255, 255, 255, 0.13)', },
                { from: 1200, to: 1275, color: 'rgba(255, 255, 255, 0.17)', },
                { from: 1275, to: 1350, color: 'rgba(255, 255, 255, 0.21)', },

                { from: 1350, to: 1425, color: 'rgba(255, 220, 80, 0.05)', },
                { from: 1425, to: 1500, color: 'rgba(255, 220, 80, 0.09)', },
                { from: 1500, to: 1575, color: 'rgba(255, 220, 80, 0.13)', },
                { from: 1575, to: 1650, color: 'rgba(255, 220, 80, 0.17)', },
                { from: 1650, to: 1725, color: 'rgba(255, 220, 80, 0.21)', },

                { from: 1725, to: 1800, color: 'rgba(100, 200, 255, 0.05)', },
                { from: 1800, to: 1875, color: 'rgba(100, 200, 255, 0.09)', },
                { from: 1875, to: 1950, color: 'rgba(100, 200, 255, 0.13)', },
                { from: 1950, to: 2025, color: 'rgba(100, 200, 255, 0.17)', },
                { from: 2025, to: 2100, color: 'rgba(100, 200, 255, 0.21)', },

                { from: 2100, to: 2175, color: 'rgba(255, 100, 255, 0.10)', },
            ];


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
            dataLabels: {
                enabled: true,
                format: '<b>{ldelim}point.name}</b>: {ldelim}point.percentage:.0f}%',
            }
        }
    },
    series: [{
        name: 'Игр',
        data: {$maps|json_encode:32},
    }]
});

</script>
{foreach from=$players item=player}
<script>
    Highcharts.chart('tdm_elo_{$player.id}', {
        title: { text: '{$player.nickname} 2x2 Elo' },
        xAxis: { type: 'datetime' },
        yAxis: {
            title: { text: null },
            softMin: 0,
            softMax: 2500,
            gridLineWidth: 0,
            plotBands: ratingPlotBands,
        },
        tooltip: { crosshairs: true, shared: true, },
        legend: { enabled: false },
        series: [{
            name: 'Рейтинг в 2х2',
            data: {$player.ratings|json_encode},
            zIndex: 1,
            marker: { lineWidth: 1 }
        }, {
            name: 'С вероятностью 68% между',
            data: {$player.deviations|json_encode},
            type: 'arearange',
            lineWidth: 0,
            linkedTo: ':previous',
            color: Highcharts.getOptions().colors[0],
            fillOpacity: 0.3,
            zIndex: 0,
            marker: {  enabled: false  }
        }]
    });
</script>
{/foreach}
</body>
</html>
