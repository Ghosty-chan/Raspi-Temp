<?php
exec('cat /sys/bus/w1/devices/w1_bus_master1/w1_master_slaves', $sensor_list_temp);

function getData($id)
{
        $id   = $id;
                #$name = exec("cat /home/pi/ntz/$id/name");
                #$subpos = strpos($name,"_");
                #$subname = substr($name,0,$subpos);
        $command = 'cat /sys/bus/w1/devices/'.$id.'/w1_slave | sed -n "s/.*t=\(.*\)/\1/p"';
        $temp = exec($command);
        $temp = ($temp / 1000);
        $temp = round($temp,1);
        $data = "$temp";
        return $data;
}


function collectData()
{
	$datum  = date("Y.n.j G:i:s");

	include 'connect.php';	
	$longdata_names = array();
	$longdata_temps = array();
	$longdata_raw	= array();
	$data_names = "`ID`,`Datum`,";
	$data_string = "'','$datum',";

	$sql = "SHOW COLUMNS FROM long_data1";
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result)){
		if( $row['Field'] != "ID" & $row['Field'] != "Datum") {
			array_push($longdata_names,$row['Field']);
		}
	}

	$sql = "SELECT `id`, `name`, `langzeit aufzeichnung?` FROM basis;";
	$result = mysqli_query($con,$sql);
	
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)){
			$id 	= $row["id"];
			$name 	= $row["name"];
			$aufzei	= $row["langzeit aufzeichnung?"];
			$datum	= date("Y.n.j G:i:s");
			
			if ($name == "") {$name = "Kein Name";}
			if ($aufzei == "1") {
				$temp = $name."-".getData($id);
				array_push($longdata_temps,$temp);
			}
		}
	}
		
		foreach ($longdata_names as $key => $value) {
			foreach ($longdata_temps as $key2 => $value2) {
				$subpos = strpos($value2,"-");
				$subname2 = substr($value2,0,$subpos);
				if($value == $subname2) { 
					$test = substr($value2,$subpos+1);
					array_push($longdata_raw,$test);
					$data_string .= "'$test',";
					$data_names  .= "`$value`,";
				}
			}
		}
		$data_string = substr($data_string,0,-1);
		$data_names  = substr($data_names,0,-1);

		$sql = "INSERT INTO long_data1 ($data_names) VALUES ($data_string)";
			echo "$datum | ";
		if(mysqli_query($con,$sql)){
			echo "New record created";
		} else {
			echo "Error creating: ". mysqli_error($con);
		}

#	mysqli_close();
	echo "<br>";
}
	collectData();


?>
