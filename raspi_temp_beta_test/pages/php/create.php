<?php

exec('cat /sys/bus/w1/devices/w1_bus_master1/w1_master_slaves', $sensor_list_temp);

foreach ($sensor_list_temp as $key => $value){
	$id = $value;
	$name = exec("cat /home/pi/ntz/$id/name");
	$subpos = strpos($name,"_");
	$subname = substr($name,0,$subpos);
	if ($oldname == $subname or $oldname == "") {
	$sensor_list[$key] = $value;
	}
	$oldname = $subname;
}

function addSensor($id)
{
	$id   = $id;
        #$name = exec("cat /home/pi/ntz/$id/name");	$subpos = strpos($name,"_");
	$name = "";
	$subpos = strpos($name,"_");
	$subname = substr($name,0,$subpos);       	
	$command = 'cat /sys/bus/w1/devices/'.$id.'/w1_slave | sed -n "s/.*t=\(.*\)/\1/p"';
	$temp = exec($command);
	$temp = ($temp / 1000);
	$temp = round($temp,2);
	$data = "$id,$name,$temp";
	
	include 'connect.php';
	$con	  = mysqli_connect($dbserver,$dbuser,$dbpw,$dbname);
	#
	if (!$con){
		echo("Connection failed! " . mysqli_connect_error());
	}
	echo "Connection successfully! <hr>";
	
	$sql = "INSERT INTO basis (`Num`, `ID`, `Name`, `Bez`, `langzeit aufzeichnung?`) VALUES (NULL, '". $id ."', '". $name ."', '0', '0')";
	
	echo "$sql <br>";

	if(mysqli_query($con,$sql)){
	echo "New record created <hr>";
	} else {
	echo "Error creating : " . mysqli_error($con);
	}
	
	mysqli_close();
}


	include 'connect.php';

        $con      = mysqli_connect($dbserver,$dbuser,$dbpw,$dbname);



$sql_get = "SELECT id FROM basis";
$result_get = mysqli_query($con,$sql_get);

if (mysqli_num_rows($result_get) > 0) {
        while($row = mysqli_fetch_assoc($result_get)){
                $id = $row["id"];
                $array[] = "$id";                
        }
} else {
        echo "0 results";
}
        mysqli_close($con);

	sort($array);

foreach ($sensor_list as $key => $value){
	if(!in_array($value,$array)) {
        addSensor($value);
#	echo "$value <br>";
	}
}
?>
