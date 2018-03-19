<!DOCTYPE html>
<head>
	<title> Grad Schaltung</title>
	<link rel="stylesheet" type="text/css" href="../conf/styles/style.css">
	<style>body{color:#fff!important;}.wrapper{width:100%;height:auto;float:left;display:inline-block;background-color:rgba(50,50,50,1);border-bottom:1px solid #151515;padding:8px 0px 5px 0px;border-radius:5px;margin-bottom:10px;}.wrapper h3{color:#fff!imporant;}.clear{clear:left;}.combined {color: #fff;padding:5px;background-color:#151515;border:#888;border-radius:25px;}</style>
</head>
<body>
<?php
	$dev_mode = 1;
	exec('cat /sys/bus/w1/devices/w1_bus_master1/w1_master_slaves', $sensor_list_temp);

function getData($id,$offset)
{
	$id   = $id;
        #$name = exec("cat /home/pi/ntz/$id/name");
		#$subpos = strpos($name,"_");
		#$subname = substr($name,0,$subpos);
	$command = 'cat /sys/bus/w1/devices/'.$id.'/w1_slave | sed -n "s/.*t=\(.*\)/\1/p"';
	$temp = exec($command);
	$temp = ($temp / 1000);
	$temp = round($temp,1) + $offset;
	$data = "$temp";
	return $data;
}
function logtoHTML( $text ) {
		$gpiologfile = "gpio_grad_log.html";
		if(!isset($fstart)){
			$fstart = fopen ($gpiologfile, "a+");
		}
		if(isset($fstart)){
		$logfile = fread($fstart, filesize($gpiologfile));
		$htmlstr = "<link rel='stylesheet' type='text/css' href='../conf/styles/style.css'><style>body{color:#fff!important;}.wrapper{width:100%;height:auto;float:left;display:inline-block;background-color:rgba(50,50,50,1);border-bottom:1px solid #151515;padding:8px 0px 5px 0px;border-radius:5px;margin-bottom:10px;}.wrapper h3{color:#fff!imporant;}.clear{clear:left;}.combined {color: #fff;padding:5px;background-color:#151515;border:#888;border-radius:25px;}</style>";
		//$htmlstrlen = strlen($htmlstr);
		//$readfirstlines = fread($fstart, $htmlstrlen);
		if($logfile) {
			fwrite($fstart, "<div class='wrapper'>");
			fwrite($fstart, "<h3>". date("Y-m-d H:i:s") ."</h3>");
			fwrite($fstart, "<span class='statusholder'>");

			echo "<div class='wrapper'>";
			echo "<h3>". date("Y-m-d H:i:s") ."</h3>";
			echo "<span class='statusholder'>";
			foreach ($text as $key => $value) {
				if( strlen($value) > 0) {
					fwrite($fstart, "$value <br>");	
					echo "$value <br>";
				} 
			}
			fwrite($fstart, "</span></div>");
			echo "</span></div>";
		} else {
			
			fwrite($fstart, "<div class='wrapper'>");
			fwrite($fstart, "<h3>". date("Y-m-d H:i:s") ."</h3>");
			fwrite($fstart, "<span class='statusholder'>");
			fwrite($fstart, "Error happend: ".$readfirstlines);
			fwrite($fstart, "fstart: ".$fstart);
			fwrite($fstart, $htmlstr." != ".$readfirstlines);

			echo "<div class='wrapper'>";
			echo "<h3>". date("Y-m-d H:i:s") ."</h3>";
			echo "<span class='statusholder'>";
			echo "Error happend: ".$readfirstlines;
			echo "fstart: ".$fstart;
			echo "<xmp>".$htmlstr." != ".$readfirstlines."</xmp>";
		}
		fclose($fstart);
		}
}
function sql_query($sql_query) {
    include "php/connect.php";
    $result = mysqli_query($con,$sql_query);
    if (!$result){
        logtoHTML(array("Abfrage konnte nicht ausgeführt werden!",mysqli_error($con)));
    }
    mysqli_close($con);
    return $result;
}
function getDBforDay($selector) {
            switch ($selector) {
                case 0:
                    $selector = "VALUE";
                    break;
                case 1:
                    $selector = "VALUE_2";
                    break;
                case 2:
                    $selector = "VALUE_3";
                    break;
                case 3:
                    $selector = "VALUE_4";
                    break;
                case 4:
                    $selector = "VALUE_5";
                    break;
                case 5:
                    $selector = "VALUE_6";
                    break;
                case 6:
                    $selector = "VALUE_7";
                    break;
                default:
                    logtoHTML(array("Selector: $selector","entspricht keiner Bedingung!"));
                    $selector = "";
                    $pin_attach = "";
                    break;
            }
    return $selector;
}
function getScheduleValues($schedule_name) {
	$now = getdate();
	$day = $now["wday"];
	$day = getDBforDay($day);

	$sql = "SELECT * FROM `configs` WHERE `KEY_ID` = '".$schedule_name."_SCHEDULE'";
	$result = sql_query($sql);
	$result = mysqli_fetch_assoc($result)[$day];
	return $result;
}
function getSliderValues($range_name) {
    $sql = "SELECT * FROM `configs` WHERE `KEY_ID` = '".$range_name."_RANGE'";
    $result = sql_query($sql);
    return $result; 
}
    // Time to select Day or Night schedule
    $dn_time_now = getdate();
    $time = $dn_time_now["hours"].":".$dn_time_now["minutes"];
    $time = strtotime($time);
    //
    $gpio_pins = array();
    $gpio_names = array();
    $gpio_ios = array();
    $gpio_status = array();

    $sql = "SELECT * FROM basis_gpio";
    $result = sql_query($sql);
    while($row = mysqli_fetch_array($result)){
        array_push($gpio_pins,$row['Pin']);
        array_push($gpio_names,$row['Name']);
        array_push($gpio_ios,$row['IO']);
    }
    foreach($gpio_names as $key => $value) {
    	if($gpio_ios[$key] == "OUT" && substr($gpio_names[$key], 0, 4) == "BHZG") {
    		$schedule_values[$value] = getScheduleValues("$value");
    		$slider_values[$value] = getSliderValues("$value");
			$day_start_values = substr($schedule_values[$value],0,strpos($schedule_values[$value],","));
			$day_start_values = strtotime($day_start_values);
			$day_end_values = substr($schedule_values[$value],(strpos($schedule_values[$value],",")+1));
			$day_end_values = strtotime($day_end_values);
			if($time > $day_start_values && $time < $day_end_values) {
    		$slider_values[$value] = mysqli_fetch_assoc($slider_values[$value])["VALUE"];
    		logtoHTML(array("Value: $value","Time: $time","Start_Values: $day_start_values","End_Values: $day_end_values"));
    		} else {
    		$slider_values[$value] = mysqli_fetch_assoc($slider_values[$value])["VALUE_2"];
    		logtoHTML(array("Value2: $value","Time: $time","Start_Values: $day_start_values","End_Values: $day_end_values"));
    		}
    		
 		}
	}
	$heute = date("D M j G:i:s T Y");
	$relais = ["KG_22","EG_23","1OG_24"];
	$temperatur_ids["1OG"] = "28-0000074d31a4";
	$temperatur_ids["EG"] = "10-0008032a2a94";
	$temperatur_ids["KG"] = "28-0000074c55fa";
	$bhzg_pin = "12";
	$sql = "SELECT * FROM basis";
	$result = sql_query($sql);
	while ($row = mysqli_fetch_array($result)){
		foreach($temperatur_ids as $id_key => $id_value) {
			if(in_array($id_value, $row)) {
				$temperatur_offsets[$id_key] = $row["offset"];
			}
		}
	}
	## 
	foreach ($temperatur_ids as $key => $value) {
		$temperatur_values[$key] = getData($value,$temperatur_offsets[$key]);
	}
	# Temperatur_array to get temp_values for if and else line 62
	##
	#$ausen_temp = getData("28-0000074d5835");
	unset($bhzg_schaltung_array);
	exec("gpio read ".$bhzg_pin,$bhzg_schaltung_array, $return);
	$bhzg_schaltung = $bhzg_schaltung_array[0];

if($bhzg_schaltung){
	#if($ausen_temp != "") {
			#$ausen_temp = $ausen_temp;
			#if ($ausen_temp <= 14) {
				logtoHTML(array("BHZG_Schaltung auf Status: ",$bhzg_schaltung));
				$i = 0;
				for ($i = 0; $i < 3; $i++) {
				$delimiter = strpos($relais[$i],"_");
				$pin = substr($relais[$i],$delimiter+1);
				$name = substr($relais[$i],0,$delimiter);
				$mode = system("gpio mode ".$pin." out");
				exec ("gpio read ".$pin, $status, $return );
				$delimiter_value = strpos($slider_values["BHZG_".$name],",");
				$min_value = substr($slider_values["BHZG_".$name],0,$delimiter_value);
				$max_value = substr($slider_values["BHZG_".$name],$delimiter_value+1);
				if($bhzg_schaltung && $status && $temperatur_values[$name] <= $max_value) {
					if(!$dev_mode) {
						system("gpio write ".$pin." 1" );
					}
					logtoHTML(array("$name eingeschalten","Aktuelle Temperatur: $temperatur_values[$name] (Offset: $temperatur_offsets[$name])","Min: $min_value"," Max: $max_value"));
				} else if ( $status && $temperatur_values[$name] > $min_value ) {
					if(!$dev_mode) {
						system("gpio write ".$pin." 0" );
					}
					logtoHTML(array("$name ausgeschalten","Aktuelle Temperatur: $temperatur_values[$name] (Offset: $temperatur_offsets[$name])","Min: $min_value"," Max: $max_value"));
				}
				}
			#} elseif ($ausen_temp > 14) {
			#	$i = 0;
			#	for ($i = 0; $i < 3; $i++) {
			#	$mode = system("gpio mode ".$relais[$i]." out");
			#	exec ("gpio read ".$relais[$i], $status, $return );
			#	system("gpio write ".$relais[$i]." 0" );
			#	}
			#	echo "######################";
			#	echo "";
			#	echo "$heute";
			#	echo "Boden Heizung - Ausgeschalten";
			#	echo "Außentemperatur: "+$ausen_temp;
			#	echo "";
			#} else {
			#	echo "######################";
			#	echo "";
			#	echo "$heute";
			#	echo "Fehler: Kein Ergebnis";
			#	echo "";
			##}
	#}
} else if (!$bhzg_schaltung) {
		$i = 0;
		for ($i = 0; $i < 3; $i++) {
		$delimiter = strpos($relais[$i],"_");
		$pin = substr($relais[$i],$delimiter+1);
		$name = substr($relais[$i],0,$delimiter);
		$mode = system("gpio mode ".$pin." out");
		exec ("gpio read ".$pin, $status, $return );
		if($status) {
			system("gpio write ".$pin." 0" );
			logtoHTML(array("$name ausgeschalten","BHZG_Schaltung: $bhzg_schaltung (aus)"));
		}
	}
} else {
	logtoHTML(array("<hr>","Error - BHZG_Schaltung kein Signal","<hr>"));
}
?>
</body>
</html>