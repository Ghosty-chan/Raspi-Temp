<html>
<head>
<script src="../scripts/jquery.js"></script>
<script src="../scripts/highchart.js"></script>
<script src="../scripts/highchart_theme.js"></script>
<link rel="stylesheet" href="../style.css">
</head>
<body> 
<?php
	$PHP = $_POST["sensoren"];
	include 'connect.php';
	
	$longdata_names = array();

	$sql = "SHOW COLUMNS FROM long_data1";
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result)){
		if( $row['Field'] != "ID" ) {
			array_push($longdata_names,$row['Field']);
			$$row['Field'] = "";
		}
	}
	$sql = "SELECT * FROM long_data1;";
	$result = mysqli_query($con,$sql);
	
	if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
			foreach ($longdata_names as $key => $value) {
				$test = $row["$value"];
				if ($value == "Datum") {
				$$value .= "'$test',";
				} else {
				$$value .= "$test,";
				}
			}
		}
	} 
	foreach ($longdata_names as $key => $value){
	$test = ${$value};	
	$werte = substr($test,0,-1);
	$check = substr($test,0,0);
		if($check = ","){
			$werte = substr($werte,2);
		}
	#$value = $werte;
	}	
			$php_result = count($PHP);
			$times = $Datum;
			$longdata_tempstring = "";
			
                        foreach ($PHP as $key => $value) {
                        $longdata_string = "";
			

                        $longdata_tempstring .= "{";
                        $name = $value;
                        $longdata_tempstring .= "name: '$name', data: [";
			$longdata_string = $$name;
                        $longdata_tempstring .= "$longdata_string]}";
                        if($key <= $php_result) {
                        $longdata_tempstring .= ", ";
                        }
                        }

	mysqli_close($con);
			echo "<script>";
			echo "
			$(function () {
			    $('#temperaturen').highcharts({
				chart: {
				    type: 'area'
				},
				title: {
				    text: 'Temperaturen'
				},
				subtitle: {
				    text: ' - '
				},
				xAxis: {
				    categories: ['08:00' , '09:00']
				},
				yAxis: {
				    title: {
					text: 'Temperature (°C)'
				    }
				},
				tooltip: {
				    crosshairs: true,
				    shared: true
				},
				plotOptions: {
				    area: {
						marker: {
							enabled: true,
							symbol: 'circle',
							radius: 2,
							states: {
								hover: {
									enabled: true
								}
							}
						}
				    },
					series: {
						fillColor: {
							linearGradient: [0, 0, 0, 300],
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						}
					}
				},
				series: [{ data: [23.0, 24.0] }]
			    });
			});
			";
			echo "</script>";
?>
</body>
</html>
