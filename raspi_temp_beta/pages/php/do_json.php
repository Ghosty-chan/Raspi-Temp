<?php
	header("content-type: application/json");
	include 'connect.php';
	$gotValue = $value;

	$sql = "select Datum,".$gotValue." from long_data1";
	$result = mysqli_query($con, $sql) or die("Error in Selecting " . mysqli($con));

	$file_output = array();

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result))
	{
				$Datum = $row['Datum'];
				$Date  = substr($Datum,0,strpos($Datum," "));
				$Time  = substr($Datum,1+strpos($Datum," "));
				$Timezeit = "$Date $Time";
				$SW_Zeit = date("I"); # Sommer / Winter Zeit
				if($SW_Zeit){
				$Datum = strtotime("$Timezeit" . "+2hours"); #Sommerzeit
				} else {
				$Datum = strtotime("$Timezeit" . "+1hours"); #Winterzeit
				}
				$Datum *= 1000;
				#$file_output[] = array( $Datum , $row[$value] );
				$file_output[] = array( $Datum , $row[$gotValue] );
	}
}

	$file_output=json_encode($file_output, JSON_NUMERIC_CHECK);
	mysqli_close($con);

?>
