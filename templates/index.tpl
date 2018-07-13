<!DOCTYPE html>
<html>
<head>
    <title>{$page_title}</title>
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
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script type="text/javascript" src="/combine.php?files=js%2Fjquery.js,js%2Fscripts.js"></script>
</head>
<body>
<div style="width:33%;float:left">
    {module name=chart mode=matches_by_player}
    {module name=chart mode=matches_by_map}
    {module name=chart mode=elo_distribution}
</div>
<div style="width:33%;float:left">
    {module name=chart mode=players_matches}
    {module name=chart mode=combined_elo gametype=tdm}
    {module name=chart mode=combined_elo gametype=duel}
</div>
<div style="width:34%;float:left">
    {module name=chart mode=all_players_list_elos}
</div>
</body>
</html>
