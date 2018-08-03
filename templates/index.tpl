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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.src.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script type="text/javascript" src="/combine.php?files=js%2Fscripts.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122950678-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){ dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'UA-122950678-1');
    </script>
</head>
<body>
{if $action == "elo"}
<div style="width: 100%; height: 100%; display: flex; align-items: center;">
    {module name=chart mode=elo_old_vs_new}
</div>
{else}
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
{/if}
</body>
</html>
