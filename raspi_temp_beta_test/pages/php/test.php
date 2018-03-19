<?php
#


include 'connect.php';
//$sensoren = array();
$sensoren = array();

/*
exec('cat /sys/bus/w1/devices/w1_bus_master1/w1_master_slaves', $sensor_list_temp);
foreach ($sensor_list_temp as $key => $value){
	$name = exec("cat /home/pi/ntz/$id/name");
	$subpos = strpos($name,"_");
	$subname = substr($name,0,$subpos);
	if ($oldname == $subname or $oldname == "") {
	$sensor_list[$key] = $value;
	}
	$oldname = $subname;
}
*/
$sql = "SELECT id, name, bez, offset FROM basis ORDER BY bez ASC";
$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result) > 0) {
	$i = 0;
	while($row = mysqli_fetch_assoc($result)){
		//var_dump($row);
		$bez = $row["bez"];
		if (substr($bez,0,strpos($bez, ".")) == $php_bez) {
		//echo "## $bez | $php_bez ## $i<br>";
		$id = $row["id"];
		$name = $row["name"];
		$offset = $row["offset"];
		$sensoren[$i] = array(substr($bez,0,strpos($bez, ".")),"$id","$name","$offset",substr($bez,strpos($bez, ".")+1));
		$i++;
		} else {
			$i = 0;
		}
		
	}
	//var_dump($sensoren);
	//echo "<hr>";
	//var_dump($sensoren[4]);
} else {
	echo "0 results";
}
	mysqli_close($con);
	foreach($sensoren as $c=>$key){
		$sort_bez[] = $key[0];
		$sort_name[] = $key[2];
		$sort_bez_end[] = $key[4];
	}
	//var_dump($sensoren);
	array_multisort($sort_bez,SORT_ASC,$sort_bez_end,SORT_ASC,$sensoren);
	//var_dump($sensoren);

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
	$old_data = 999;
	echo "<table>";
	for ($i = 0; $i < count($sensoren); $i++) {
	$value = $sensoren[$i];

	/*$subpos1 = strpos($value," - ",1);
	$subpos2 = strpos($value," - ",3);
	# 3 4
	$subbez = substr($value,0,$subpos1);
	if($subbez==9){
	$col=1;
	} else {
	$col=0;
	}
	if($subbez<10){
		$subid = substr($value,$subpos1+3,$subpos2-4);
			//echo "test1 $subid<br>";
	} else {
        $subid = substr($value,$subpos1+3,$subpos2-5);
        	//echo "test2 $subid<br>";
	}
	$data = explode(" - ",$value);
	*/
	$temp = getData($value[1],$value[3]);
	if ($value[0] != $old_data AND $old_data != 999 ) {
#	echo "<tr id='tb_data'><td id='td_num'><hr></td><td id='td_id'> </td><td id='td_name'> </td><td id='td_temp'> </td></tr>";
		echo "<tr id='tb_data_2'><td colspan='4'><div style='width:100%;height:2px;background-color:#555;'></div></td></tr>";
		$old_data = $value[0];
	}
	if ($old_data == "999"){
		$old_data = $value[0];
	}
	#echo "<tr id='tb_data'><td id='td_num'> $data[0] </td><td id='td_id'> $data[1] </td><td id='td_name'> $data[2] </td><td id='td_temp'> $temp </td></tr>";
	echo "<tr id='tb_data'><td id='td_name'><span class='group_id'>$value[0] - $value[4]</span> | $value[2] </td><td id='td_temp'> $temp </td></tr>
				<tr><td colspan='2'><meter min='-20' low='15' optimum='25' high='50' max='80' class='meterbar' value='$temp'>	<span style='width: ".($temp)."%'><span></span></span>	</meter></td></tr>";
				#<tr><td colspan='2'><div class='meter animate'>	<span style='width: ".($temp)."%'><span></span></span>	</div></td></tr>";
	}
	echo "<tr id='tb_data2'><td colspan='4'><div style='width:100%;height:2px;background-color:#333;'></div></td></tr>";
	echo "</table>";
?>
