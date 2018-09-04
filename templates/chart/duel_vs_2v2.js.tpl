{
    chart: {
        type: 'scatter',
        events: {
            load: function () {/*
                let min = eonMinElo+50, max = eonMaxElo-200;

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
                */
            }
        }
    },
    title: { text: 'Duel vs 2v2 ratings' },
    subtitle: { text: 'Based on ' + {$elo|count} + ' players' },
    xAxis: {
        title: { text: 'Duel rating' },
        startOnTick: true,
        endOnTick: true,
        showLastLabel: true,
        gridLineWidth: 1,
        min: eonMinElo,
        max: eonMaxElo,
        width: eonSize,
        height: eonSize,
        tickInterval: 150,
        gridLineColor: 'rgba(60,60,60,0.15)',
        tickColor: 'rgba(120,120,120,0.15)',
        lineColor: 'rgba(120,120,120,0.15)',
    },
    yAxis: {
        title: { text: '2v2 rating' },
        min: eonMinElo,
        max: eonMaxElo,
        width: eonSize,
        height: eonSize,
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
                pointFormat: 'Duel: {ldelim}point.x}<br/>2v2: {ldelim}point.y}'
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
            name: 'Duel vs 2v2',
            data: {$elo|json_encode:32},
            turboThreshold: 5000
        }
    ],
}