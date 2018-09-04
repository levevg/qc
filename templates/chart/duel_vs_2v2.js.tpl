{
    chart: {
        type: 'scatter',
        events: {
            load: function () {
                let min = eonMinElo+50, max = eonMaxElo-200;

                this.renderer.path(['M', this.xAxis[0].toPixels(min), this.yAxis[0].toPixels(min),
                                    'L', this.xAxis[0].toPixels(max), this.yAxis[0].toPixels(max)])
                    .attr({ 'stroke-width': 1, 'stroke': 'rgba(100,100,100,0.5)' })
                    .add();
                this.renderer.text('2v2 = duel', 270, 515)
                    .css({
                        color: 'rgba(120,120,120,0.7)',
                        fontSize: '11px',
                        transform: 'rotate(-45deg)',
                    }).add();

                var a = min*{$elo_slope} + {$elo_offset},
                    b = max*{$elo_slope} + {$elo_offset};

                this.renderer.path(['M', this.xAxis[0].toPixels(min), this.yAxis[0].toPixels(a),
                                    'L', this.xAxis[0].toPixels(max), this.yAxis[0].toPixels(b)])
                    .attr({ 'stroke-width': 1, 'stroke': 'rgba(0,179,176,0.2)' })
                    .add();

                var angle = Math.atan(-{$elo_slope}), x = this.xAxis[0].toPixels(max), y = this.yAxis[0].toPixels({$elo_slope}*max + {$elo_offset}),
                    nx = Math.cos(-angle)*x - Math.sin(-angle)*y - 50, ny = Math.sin(-angle)*x + Math.cos(-angle)*y+15;
                this.renderer.text('2v2 = ' + (Math.round({$elo_slope}*100)/100) + ' * duel + ' + Math.round({$elo_offset}), nx, ny)
                    .css({
                        color: 'rgba(0,179,176,0.4)',
                        fontSize: '11px',
                        transform: 'rotate(' + Math.round(angle*180/Math.PI) + 'deg)',
                    }).add();
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