<?php
// First Connection

include 'connect.php';

// Fetch Data
// Lets get actual date and fetch the data from it which is older than xy days

$data="";
$deleteafterdays=30; // j.n.Y G:i:s
$curdate=date("j.n.Y");
$deldate=strtotime("-1 month", strtotime($curdate));
$deldate=date("j.n.Y", $deldate);

$sql='SELECT * FROM `long_data1` WHERE `Datum` < DATE_SUB(NOW(), INTERVAL 1 MONTH)';
$result=mysqli_query($con,$sql);

$id_array=array();
$data=array();

if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)){
		$id=$row["ID"];
		array_push($data,$row);
		array_push($id_array, $id);
	}
}
foreach ($id_array as $key => $value) {
	$delete_string.="$value,";
}
	$delete_string=substr($delete_string, 0, -1);
	$sql="DELETE FROM long_data1 WHERE ID IN ($delete_string);";
	$result=mysqli_query($con,$sql);


// Reorder Mysql table

$sql="SET @num := 0;UPDATE `long_data1` SET `ID` = @num := (@num+1);ALTER TABLE `long_data1` AUTO_INCREMENT =1;";

$result=mysqli_multi_query($con,$sql);

// First Connection done
mysqli_close($con);

// Open Second one

include('connect2.php');

// Export Data to other Server

	// Date Variables for actual Date
	$dbdate=strtotime("-1 month", strtotime($curdate));
	$dbdate=date("F-Y", $dbdate);
	//

$sql='CREATE TABLE IF NOT EXISTS `'.$dbdate.'` (`ID` int(11) NOT NULL,  `Datum` datetime NOT NULL,  `1OG_KZ` text NOT NULL,  `1OG_RL` text NOT NULL,  `1OG_VL` text NOT NULL,  `BHZG_RL` text NOT NULL,  `BHZG_VL` text NOT NULL,  `EG_RL` text NOT NULL,  `EG_VL` text NOT NULL,  `ETH_RL` text NOT NULL,  `ETH_VL` text NOT NULL,  `HZG_RL` text NOT NULL,  `HZG_VL` text NOT NULL,  `HZV_Temp` text NOT NULL,  `KG_RL` text NOT NULL,  `KG_VL` text NOT NULL,  `KG_KZ` text NOT NULL,  `Solar_RL` text NOT NULL,  `Solar_VL` text NOT NULL,  `WW_Sp_RL` text NOT NULL,  `WW_Sp_VL` text NOT NULL,  `WW_Sp_Eintritt` text NOT NULL,  `WW_Sp_Mitte` text NOT NULL,  `WW_Sp_Austritt` text NOT NULL,  `Aussen_Temp` text) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;ALTER TABLE `'.$dbdate.'` ADD PRIMARY KEY (`ID`);ALTER TABLE `'.$dbdate.'` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;';

$result=mysqli_multi_query($con2,$sql);

mysqli_close($con2);
sleep(5);
include('connect2.php');

foreach ($data as $data_key => $data_value) {
		$sql_add="";
	foreach($data_value as $array_key => $array_value) {
		$sql_add .= "' $array_value',";
	}
		$sql_add_find=strpos($sql_add,",");
		$sql_add=substr($sql_add,$sql_add_find+1,-1);


$result=mysqli_query($con2,$sql);
}
mysqli_close($con2);
?>


