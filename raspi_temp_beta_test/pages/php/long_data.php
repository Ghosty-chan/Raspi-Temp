<html>
<head>
<script src="../conf/scripts/jquery.js"></script>
<script src="../conf/scripts/highchart.js"></script>
<script src="../conf/scripts/highchart_theme.js"></script>
<!--<script src="https://code.highcharts.com/highcharts-more.js"></script>-->

</head>
<body>
<?php
$series = "";
foreach ($temp_value as $key => $value) {
    include 'do_json.php';

    $series .= '{
                type: "area",
                name: "'.$value.' °C",
                data: '.$file_output.'
              },';

}
  $series = substr($series,0,-1);
?>
<script>
$(function () {
	// http://jsfiddle.net/gh/get/jquery/1.9.1/highslide-software/highcharts.com/tree/master/samples/stock/demo/lazy-loading/
	// Links..
    //$.getJSON('php/do_json.php', function (data) {
      $('#high_container').highcharts({
         chart: {
             zoomType: 'x',
             resetZoomButton: {
                    position: {
                        align: 'left',
                        verticalAlign: 'bottom',
                        x: 0,
                        y: 30
                    }
             }
         },
         title: {
             text: 'Temperaturen'
         },
         subtitle: {
             text: document.ontouchstart === undefined ?
                     'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
         },
         xAxis: {
             type: 'datetime'
         },
         yAxis: {
             title: {
                 text: 'Celsius °C'
             }
         },
         legend: {
             enabled: true
         },
         plotOptions: {
             area: {

                 marker: {
                     radius: 1
                 },
                 lineWidth: 1,
                 states: {
                     hover: {
                         lineWidth: 1
                     }
                 },
                 threshold: null
             }
         },

         series: [
            <?php echo $series; ?>
         ]
     });
  // });
});

</script>
	<div id="high_container" style="min-width: 400px; width: 100%;min-height: 450px; margin: 0 auto"></div>
</body>
</html>
