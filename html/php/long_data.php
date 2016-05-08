<html>
<head>
<script src="../scripts/jquery.js"></script>
<script src="../scripts/highchart.js"></script>
<link rel="stylesheet" href="../style.css">
</head>
<body style="background-color:#fff"> 
<?php
	$PHP = $_POST["sensoren"];
	echo "<hr>";
	echo "<div id='Temperaturen' style='width:100%;height:400px;'></div>";
	include 'connect.php';
	
	$longdata_names = array();

	$sql = "SHOW COLUMNS FROM long_data1";
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result)){
		if( $row['Field'] != "ID" ) {
			array_push($longdata_names,$row['Field']);
			$$row['Field'] == array();
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
	} else {
		echo "0 results <br>";
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

	mysqli_close();
			echo "<script>";
			echo "
			$(function () {
			    $('#Temperaturen').highcharts({
				chart: {
				    type: 'spline'
				},
				title: {
				    text: 'Temperaturen'
				},
				subtitle: {
				    text: '0'
				},
				xAxis: {
				    categories: [$times]
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
				    spline: {
					marker: {
						radius: 4,
						lineColor: '#666666',
						lineWidth: 1
					}
				    }
				},
				series: [$longdata_tempstring]
			    });
			});
			";
			echo "</script>";
	echo "<hr>";
?>
</body>
</html>
