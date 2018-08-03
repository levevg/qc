Highcharts.createElement('link', {
    href: 'https://fonts.googleapis.com/css?family=Roboto+Condensed&subset=cyrillic',
    rel: 'stylesheet',
    type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

Highcharts.theme = {
    colors: ['#00b3b0', '#ffec87', '#4aacd4', '#cecdc9', '#eeaaee', '#c97a54', '#78cf7c', '#fc9696', '#6e67c9', '#d1c5af', '#adb1c5', '#c8d071'],
    chart: {
        backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
            stops: [
                [0, '#262627'],
                [1, '#383839']
            ]
        },
        style: {
            fontFamily: '\'Roboto Condensed\', sans-serif'
        },
        plotBorderColor: '#606063'
    },
    title: {
        align: 'left',
        style: {
            color: '#E0E0E3',
            fontSize: '18px'
        }
    },
    subtitle: {
        style: {
            color: '#E0E0E3',
        }
    },
    xAxis: {
        gridLineColor: '#707073',
        labels: {
            style: {
                color: '#E0E0E3'
            }
        },
        lineColor: '#707073',
        minorGridLineColor: '#505053',
        tickColor: '#707073',
        title: {
            style: {
                color: '#A0A0A3'
            }
        }
    },
    loading: {
        style: {
            backgroundColor: '#000000',
        }
    },
    yAxis: {
        gridLineColor: '#707073',
        labels: {
            style: {
                color: '#E0E0E3'
            }
        },
        lineColor: '#707073',
        minorGridLineColor: '#505053',
        tickColor: '#707073',
        tickWidth: 1,
        title: {
            style: {
                color: '#A0A0A3'
            }
        }
    },
    tooltip: {
        backgroundColor: 'rgba(0, 0, 0, 0.65)',
        style: {
            color: '#F0F0F0'
        }
    },
    plotOptions: {
        series: {
            dataLabels: {
                color: '#B0B0B3'
            },
            marker: {
                lineColor: '#333'
            }
        },
        boxplot: {
            fillColor: '#505053'
        },
        candlestick: {
            lineColor: 'white'
        },
        errorbar: {
            color: 'white'
        }
    },
    legend: {
        itemStyle: {
            color: '#E0E0E3'
        },
        itemHoverStyle: {
            color: '#FFF'
        },
        itemHiddenStyle: {
            color: '#606063'
        }
    },
    credits: {
        style: {
            color: '#666'
        }
    },
    labels: {
        style: {
            color: '#707073'
        }
    },

    drilldown: {
        activeAxisLabelStyle: {
            color: '#F0F0F3'
        },
        activeDataLabelStyle: {
            color: '#F0F0F3'
        }
    },

    navigation: {
        buttonOptions: {
            symbolStroke: '#DDDDDD',
            theme: {
                fill: '#505053'
            }
        }
    },

    // scroll charts
    rangeSelector: {
        buttonTheme: {
            fill: '#505053',
            stroke: '#000000',
            style: {
                color: '#CCC'
            },
            states: {
                hover: {
                    fill: '#707073',
                    stroke: '#000000',
                    style: {
                        color: 'white'
                    }
                },
                select: {
                    fill: '#000003',
                    stroke: '#000000',
                    style: {
                        color: 'white'
                    }
                }
            }
        },
        inputBoxBorderColor: '#505053',
        inputStyle: {
            backgroundColor: '#333',
            color: 'silver'
        },
        labelStyle: {
            color: 'silver'
        }
    },

    navigator: {
        handles: {
            backgroundColor: '#666',
            borderColor: '#AAA'
        },
        outlineColor: '#CCC',
        maskFill: 'rgba(255,255,255,0.1)',
        series: {
            color: '#7798BF',
            lineColor: '#A6C7ED'
        },
        xAxis: {
            gridLineColor: '#505053'
        }
    },

    scrollbar: {
        barBackgroundColor: '#808083',
        barBorderColor: '#808083',
        buttonArrowColor: '#CCC',
        buttonBackgroundColor: '#606063',
        buttonBorderColor: '#606063',
        rifleColor: '#FFF',
        trackBackgroundColor: '#404043',
        trackBorderColor: '#404043'
    },

    // special colors for some of the
    legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
    background2: '#505053',
    dataLabelsColor: '#B0B0B3',
    textColor: '#C0C0C0',
    contrastTextColor: '#F0F0F3',
    maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);

const ratingPlotBands = [
    { from: 500,  to: 600,  color: 'rgba(170, 81, 38, 0.03)',},
    { from: 600,  to: 700,  color: 'rgba(170, 81, 38, 0.04)',},
    { from: 700,  to: 1075,  color: 'rgba(170, 81, 38, 0.05)',},
    { from: 1075,  to: 1450, color: 'rgba(206, 205, 201, 0.05)',},
    { from: 1450, to: 1825, color: 'rgba(255, 236, 135, 0.05)',},
    { from: 1825, to: 2200, color: 'rgba(74, 172, 212, 0.05)',},
    { from: 2200, to: 2275, color: 'rgba(192, 16, 152, 0.05)',},
    { from: 2275, to: 2350, color: 'rgba(192, 16, 152, 0.04)',},
    { from: 2350, to: 2425, color: 'rgba(192, 16, 152, 0.03)',},
];
const ratingPlotLines = [
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 775, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 850, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 925, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1000, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1075, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1150, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1225, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1300, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1375, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1450, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1525, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1600, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1675, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1750, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1825, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1900, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1975, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 2050, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 2125, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 2200, dashStyle: 'ShortDot' },
];

function eloDistributionTooltipFormatter() {
    if (this.x=='Elite') return 'Группа <b>{$elite}+' +
        '</b><br/>Дуэли: <b>' + this.points[0].y + '</b> игроков<br/>2v2: <b>' + this.points[1].y + '</b> игроков';
    if (!parseInt(this.x)) return 'Инфа доступна только<br/>по топ-5000';
    return 'Группа <b>' + this.x + '-' + (this.x+74) +
        '</b><br/>Дуэли: <b>' + this.points[0].y + '</b> игроков<br/>2v2: <b>' + this.points[1].y + '</b> игроков';
}

function reloadChart(chartId, chartObject, link) {
    chartObject.showLoading();
    $.get(link, function(data) {
        eval.call(window, data);
        chartObject.update(window[chartId + '_data'], true, true);
        chartObject.hideLoading();
    });
}