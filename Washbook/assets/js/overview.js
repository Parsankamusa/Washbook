(function($) {
"use strict";

    var dom = document.getElementById("container");
    var myChart = echarts.init(dom);
    var app = {};
    var option = {
        legend: {
            show: false,
        },
        toolbox: {
            show: false,
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br />{b} : {c} ({d}%)"
        },
        color: ["#f62d51", "#dddddd", "#ffbc34", "#7460ee", "#009efb", "#2f3d4a", "#90a4ae", "#55ce63"],
        series: [{
            name: 'Nightingale Chart',
            type: 'pie',
            center: ['50%', '50%'],
            roseType: 'area',
            itemStyle: {
                borderRadius: 8
            },
            data: servicesales
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }


    function gradientBlue() {
        var chart = document.getElementById('revenue').getContext('2d'),
            gradient = chart.createLinearGradient(0, 0, 0, 450);

        gradient.addColorStop(0, 'rgba(0,123,255, 0.6)');
        gradient.addColorStop(0.5, 'rgba(0,123,255, 0.1)');
        gradient.addColorStop(1, 'rgba(0,123,255, 0)');

        return gradient;
    }


    // payments
    var presets = window.chartColors;
    // var utils = Samples.utils;
    var inputs = {
        min: -100,
        max: 100,
        count: 8,
        decimals: 2,
        continuity: 1
    };

    var options = {
        maintainAspectRatio: false,
        spanGaps: false,
        elements: {
            line: {
                tension: 0.000001
            }
        },
        plugins: {
            filler: {
                propagate: false
            }
        },
        scales: {
            xAxes: [{
                ticks: {
                    autoSkip: false,
                    maxRotation: 0
                }
            }]
        }
    };

    // reset the random seed to generate the same data for all charts
    // utils.srand(8);

    new Chart("revenue", {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                backgroundColor: gradientBlue(),
                borderColor: 'rgb(0,123,255)',
                data: amounts,
                label: 'Sales',
                borderWidth: 4,
                pointBorderWidth: 2,
                pointBackgroundColor: "#fff",
                pointRadius: 5,
                pointHitRadius: 3,
                tension: 0.4,
                fill: 'start'
            }]
        },
        options: Chart.helpers.merge(options, {
            title: {
                text: 'Sales Revenue (' + currency + ')',
                display: true
            }
        })
    });


})(jQuery);