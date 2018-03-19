<?php
#


include 'connect.php';
$array = array();
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
$sql = "SELECT id, name, bez, offset FROM basis";
$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)){
		$bez = $row["bez"];
		if (in_array($bez,$php_id)) {
		$id = $row["id"];
		$name = $row["name"];
		$offset = $row["offset"];
		$array[] = "$bez - $id - $name - $offset";
		}
	}
} else {
	echo "0 results";
}
	mysqli_close($con);

array_multisort($array,SORT_ASC,SORT_NUMERIC);

sort($array);

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
foreach ($array as $key => $value){
	$subpos1 = strpos($value," - ",1);
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
	} else {
        $subid = substr($value,$subpos1+3,$subpos2-5);
	}
	$data = explode(" - ",$value);
	$temp = getData($subid,$data[3]);
	if ($data[0] != $old_data AND $old_data != 999 ) {
#	echo "<tr id='tb_data'><td id='td_num'><hr></td><td id='td_id'> </td><td id='td_name'> </td><td id='td_temp'> </td></tr>";
	echo "<tr id='tb_data_2'><td colspan='4'><div style='width:100%;height:2px;background-color:#555;'></div></td></tr>";
		$old_data = $data[0];
	}
	if ($old_data == "999"){
		$old_data = $data[0];
	}
	#echo "<tr id='tb_data'><td id='td_num'> $data[0] </td><td id='td_id'> $data[1] </td><td id='td_name'> $data[2] </td><td id='td_temp'> $temp </td></tr>";
	echo "<tr id='tb_data'><td id='td_name'> $data[2] </td><td id='td_temp'> $temp </td></tr>
				<tr><td colspan='2'><meter min='-20' low='15' optimum='25' high='50' max='80' class='meterbar' value='$temp'>	<span style='width: ".($temp)."%'><span></span></span>	</meter></td></tr>";
				#<tr><td colspan='2'><div class='meter animate'>	<span style='width: ".($temp)."%'><span></span></span>	</div></td></tr>";
}
	echo "<tr id='tb_data2'><td colspan='4'><div style='width:100%;height:2px;background-color:#333;'></div></td></tr>";
	echo "</table>";
?>
