<div style="width: 100%; height: 100%; display: flex; align-items: center;">
    <div id="{$chart_id}" style="width: 700px; height: 710px; margin: 0 auto;"></div>
</div>
<script>
    let size = 600, minElo = 600, maxElo = 3000;
    var chart = {
        chart: { type: 'scatter',
            events: {
                load: function () {
                    let min = minElo+50, max = maxElo-200;

                    this.renderer.path(['M', this.xAxis[0].toPixels(min), this.yAxis[0].toPixels(min),
                                        'L', this.xAxis[0].toPixels(max), this.yAxis[0].toPixels(max)])
                        .attr({ 'stroke-width': 1, 'stroke': 'rgba(60,60,60,0.15)' })
                        .add();

                    var a = min*{$duel_slope} + {$duel_offset},
                        b = max*{$duel_slope} + {$duel_offset};

                    this.renderer.path(['M', this.xAxis[0].toPixels(min), this.yAxis[0].toPixels(a),
                                        'L', this.xAxis[0].toPixels(max), this.yAxis[0].toPixels(b)])
                        .attr({ 'stroke-width': 1, 'stroke': 'rgba(0,179,176,0.2)' })
                        .add();

                    var c = min*{$tdm_slope} + {$tdm_offset},
                        d = max*{$tdm_slope} + {$tdm_offset};

                    this.renderer.path(['M', this.xAxis[0].toPixels(min), this.yAxis[0].toPixels(c),
                        'L', this.xAxis[0].toPixels(max), this.yAxis[0].toPixels(d)])
                        .attr({ 'stroke-width': 1, 'stroke': 'rgba(255,236,135,0.2)' })
                        .add();

                    var angle = Math.atan(-{$duel_slope}), x = this.xAxis[0].toPixels(max), y = this.yAxis[0].toPixels({$duel_slope}*max + {$duel_offset}),
                        nx = Math.cos(-angle)*x - Math.sin(-angle)*y - 50, ny = Math.sin(-angle)*x + Math.cos(-angle)*y+15;
                    this.renderer.text('new = ' + (Math.round({$duel_slope}*100)/100) + ' * old + ' + Math.round({$duel_offset}), nx, ny)
                        .css({
                            color: 'rgba(0,179,176,0.4)',
                            fontSize: '11px',
                            transform: 'rotate(' + Math.round(angle*180/Math.PI) + 'deg)',
                        }).add();

                    var angle = Math.atan(-{$tdm_slope}), x = this.xAxis[0].toPixels(max), y = this.yAxis[0].toPixels({$tdm_slope}*max + {$tdm_offset}),
                        nx = Math.cos(-angle)*x - Math.sin(-angle)*y - 50, ny = Math.sin(-angle)*x + Math.cos(-angle)*y-10;
                    this.renderer.text('new = ' + (Math.round({$tdm_slope}*100)/100) + ' * old + ' + Math.round({$tdm_offset}), nx, ny)
                        .css({
                            color: 'rgba(255,236,135,0.4)',
                            fontSize: '11px',
                            transform: 'rotate(' + Math.round(angle*180/Math.PI) + 'deg)',
                        }).add();
                }
            }
        },
        title: { text: 'New rating vs Old rating' },
        subtitle: { text: 'Based on ' + {$duel|count} + ' duel and ' + {$tdm|count} + ' tdm (2v2) players' },
        xAxis: {
            title: { text: 'Before reset' },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true,
            gridLineWidth: 1,
            min: minElo,
            max: maxElo,
            width: size,
            height: size,
            tickInterval: 150,
            gridLineColor: 'rgba(60,60,60,0.15)',
            tickColor: 'rgba(120,120,120,0.15)',
            lineColor: 'rgba(120,120,120,0.15)',
        },
        yAxis: {
            title: { text: 'After reset' },
            min: minElo,
            max: maxElo,
            width: size,
            height: size,
            tickInterval: 150,
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true,
            gridLineWidth: 1,
            gridLineColor: 'rgba(60,60,60,0.15)',
            tickColor: 'rgba(120,120,120,0.15)',
            lineColor: 'rgba(120,120,120,0.15)',
        },
        plotOptions: {
            scatter: {
                marker: { radius: 1, },
                tooltip: {
                    headerFormat: '<span style="font-size:150%; font-weight: bold">{ldelim}point.key}</span> - <i>{ldelim}series.name}</i><br/>.<br/>',
                    pointFormat: 'Old: {ldelim}point.x}<br/>New: {ldelim}point.y}'
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'top',
            x: -40, y: 25,
            floating: true,
            backgroundColor: '#444',
        },
        series: [
            {
                name: 'Duel',
                data: {$duel|json_encode:32},
                turboThreshold: 5000
            },
            {
                name: '2v2',
                data: {$tdm|json_encode:32},
                turboThreshold: 5000
            }
        ],
    };
    Highcharts.chart('{$chart_id}', chart);
</script>