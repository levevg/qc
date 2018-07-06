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
    { from: 400,  to: 500,  color: 'rgba(170, 81, 38, 0.03)',},
    { from: 500,  to: 600,  color: 'rgba(170, 81, 38, 0.04)',},
    { from: 600,  to: 975,  color: 'rgba(170, 81, 38, 0.05)',},
    { from: 975,  to: 1350, color: 'rgba(206, 205, 201, 0.05)',},
    { from: 1350, to: 1725, color: 'rgba(255, 236, 135, 0.05)',},
    { from: 1725, to: 2100, color: 'rgba(74, 172, 212, 0.05)',},
    { from: 2100, to: 2175, color: 'rgba(192, 16, 152, 0.05)',},
    { from: 2175, to: 2250, color: 'rgba(192, 16, 152, 0.04)',},
    { from: 2250, to: 2325, color: 'rgba(192, 16, 152, 0.03)',},
];
const ratingPlotLines = [
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 675, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 750, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 825, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 900, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 975, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1050, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1125, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1200, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1275, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1350, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1425, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1500, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1575, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1650, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1725, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1800, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1875, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 1950, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 2025, dashStyle: 'ShortDot' },
    { color: 'rgba(255, 255, 255, 0.1)', width: 1, value: 2100, dashStyle: 'ShortDot' },
];