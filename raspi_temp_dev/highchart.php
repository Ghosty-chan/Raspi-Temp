﻿<html>
<head>
<script src="conf/scripts/jquery.js"></script>
<script src="conf/scripts/highchart.js"></script>

<!--<script src="conf/scripts/highchart_theme.js"></script>-->
</head>
<body>

<script>
$(function () {
	// http://jsfiddle.net/gh/get/jquery/1.9.1/highslide-software/highcharts.com/tree/master/samples/stock/demo/lazy-loading/
	// Links..
    $.getJSON('http://192.168.0.126/raspi_temp_beta/pages/php/do_json.php', function (data) {
        var detailChart;

        $(document).ready(function () {

            // create the detail chart
            function createDetail(masterChart) {

                // prepare the detail chart
                var detailData = [],
                    detailStart = data[0][0];

                $.each(masterChart.series[0].data, function () {
                    if (this.x >= detailStart) {
                        detailData.push(this.y);
                    }
                });

                // create a detail chart referenced by a global variable
                detailChart = $('#detail-container').highcharts({
                    chart: {
						zoomType: 'x',
                        marginBottom: 120,
                        reflow: false,
                        marginLeft: 50,
                        marginRight: 20,
                        style: {
                            position: 'absolute'
                        }
                    },
					rangeSelector: {
						allButtonsEnabled: true,
						selected: 0
					},
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: 'Home Sensors'
                    },
                    subtitle: {
                        text: 'Select an area by dragging across the lower chart'
                    },
                    xAxis: {
                        type: 'datetime'
                    },
                    yAxis: {
                        title: {
                            text: null
                        },
                        maxZoom: 0.1
                    },
                    tooltip: {
                        /*formatter: function () {
                            var point = this.points[0];
                            return '<b>' + point.series.name + '</b><br/>' + Highcharts.dateFormat('%A %B %e %Y', this.x) + ':<br/>' +
                                '1 USD = ' + Highcharts.numberFormat(point.y, 2) + ' EUR';
                        },*/
                        shared: true
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            marker: {
                                enabled: false,
                                states: {
                                    hover: {
                                        enabled: true,
                                        radius: 3
                                    }
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Temperatur',
                        pointStart: detailStart,
                        pointInterval: 24 * 3600 * 1000,
                        data: detailData
                    }],

                    exporting: {
                        enabled: false
                    }

                }).highcharts(); // return chart
            }

            // create the master chart
            function createMaster() {
                $('#master-container').highcharts({
                    chart: {
                        reflow: false,
                        borderWidth: 0,
                        backgroundColor: null,
                        marginLeft: 50,
                        marginRight: 20,
                        zoomType: 'x',
                        events: {

                            // listen to the selection event on the master chart to update the
                            // extremes of the detail chart
                            selection: function (event) {
                                var extremesObject = event.xAxis[0],
                                    min = extremesObject.min,
                                    max = extremesObject.max,
                                    detailData = [],
                                    xAxis = this.xAxis[0];

                                // reverse engineer the last part of the data
                                $.each(this.series[0].data, function () {
                                    if (this.x > min && this.x < max) {
                                        detailData.push([this.x, this.y]);
                                    }
                                });

                                // move the plot bands to reflect the new detail span
                                xAxis.removePlotBand('mask-before');
                                xAxis.addPlotBand({
                                    id: 'mask-before',
                                    from: data[0][0],
                                    to: min,
                                    color: 'rgba(0, 0, 0, 0.2)'
                                });

                                xAxis.removePlotBand('mask-after');
                                xAxis.addPlotBand({
                                    id: 'mask-after',
                                    from: max,
                                    to: data[data.length - 1][0],
                                    color: 'rgba(0, 0, 0, 0.2)'
                                });


                                detailChart.series[0].setData(detailData);

                                return false;
                            }
                        }
                    },
                    title: {
                        text: null
                    },
                    xAxis: {
                        type: 'datetime',
                        showLastTickLabel: true,
                        //maxZoom: 14 * 24 * 3600000, // fourteen days
						maxZoom: 0.1,
                        plotBands: [{
                            id: 'mask-before',
                            from: data[0][0],
                            to: data[data.length - 1][0],
                            color: 'rgba(0, 0, 0, 0.2)'
                        }],
                        title: {
                            text: null
                        }
                    },
                    yAxis: {
                        gridLineWidth: 0,
                        labels: {
                            enabled: false
                        },
                        title: {
                            text: null
                        },
                        min: 0.6,
                        showFirstLabel: false
                    },
                  /*  tooltip: {
                        formatter: function () {
                            return false;
                        }
                    }, */
                    legend: {
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            fillColor: {
                                linearGradient: [0, 0, 0, 70],
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [1, 'rgba(255,255,255,0)']
                                ]
                            },
                            lineWidth: 1,
                            marker: {
                                enabled: false
                            },
                            shadow: false,
                            states: {
                                hover: {
                                    lineWidth: 1
                                }
                            },
                            enableMouseTracking: false
                        }
                    },

                    series: [{
                        type: 'area',
                        name: 'Temperatures',
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: data[1][0],
                        data: data
                    }],

                    exporting: {
                        enabled: true
                    }

                }, function (masterChart) {
                    createDetail(masterChart);
                })
                    .highcharts(); // return chart instance
            }

            // make the container smaller and add a second container for the master chart
            var $container = $('#container')
                .css('position', 'relative');
			$('<div id="highcharts-range-selector-buttons">')
				.appendTo($container);
            $('<div id="detail-container">')
                .appendTo($container);

            $('<div id="master-container">')
                .css({
                    position: 'absolute',
                    top: 300,
                    height: 125,
                    width: '100%'
                })
                    .appendTo($container);

            // create master and in its callback, create the detail chart
            createMaster();
        });
    });
});
</script>
	<div id="container" style="min-width: 400px; width: 100%;height: 400px; margin: 0 auto"></div>
</body>
</html>
