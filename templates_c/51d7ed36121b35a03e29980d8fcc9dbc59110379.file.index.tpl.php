<?php /* Smarty version Smarty-3.0.5, created on 2018-07-04 16:22:07
         compiled from "/var/www/unseen/qc.unseen.in/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8331248975b3cc9ff0989f3-69822663%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '51d7ed36121b35a03e29980d8fcc9dbc59110379' => 
    array (
      0 => '/var/www/unseen/qc.unseen.in/templates/index.tpl',
      1 => 1530710524,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8331248975b3cc9ff0989f3-69822663',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_global')) include '/var/www/unseen/qc.unseen.in/3rdparty/smarty/plugins/function.global.php';
?><!DOCTYPE html>
<html>
<head>
    <title><?php echo smarty_function_global(array('var'=>'page_title'),$_smarty_tpl);?>
</title>
    <meta name="keywords" content="<?php echo smarty_function_global(array('var'=>'meta_keywords'),$_smarty_tpl);?>
"/>
    <meta name="description" content="<?php echo smarty_function_global(array('var'=>'meta_description'),$_smarty_tpl);?>
"/>
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
<?php  $_smarty_tpl->tpl_vars['player'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('players')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['player']->key => $_smarty_tpl->tpl_vars['player']->value){
?><div id="tdm_elo_<?php echo $_smarty_tpl->tpl_vars['player']->value['id'];?>
" class="chart"></div><?php }} ?>
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
        pointFormat: '{series.name}: <b>{point.y}</b>'
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.0f}%',
            }
        }
    },
    series: [{
        name: 'Игр',
        data: <?php echo json_encode($_smarty_tpl->getVariable('maps')->value,32);?>
,
    }]
});

</script>
<?php  $_smarty_tpl->tpl_vars['player'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('players')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['player']->key => $_smarty_tpl->tpl_vars['player']->value){
?>
<script>
    Highcharts.chart('tdm_elo_<?php echo $_smarty_tpl->tpl_vars['player']->value['id'];?>
', {
        title: { text: '<?php echo $_smarty_tpl->tpl_vars['player']->value['nickname'];?>
 2x2 Elo' },
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
            data: <?php echo json_encode($_smarty_tpl->tpl_vars['player']->value['ratings']);?>
,
            zIndex: 1,
            marker: { lineWidth: 1 }
        }, {
            name: 'С вероятностью 68% между',
            data: <?php echo json_encode($_smarty_tpl->tpl_vars['player']->value['deviations']);?>
,
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
<?php }} ?>
</body>
</html>
