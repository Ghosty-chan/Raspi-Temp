<?php

// Database Connection

include 'connect.php';

$connection=mysql_connect($dbserver,$dbuser,$dbpw); 

echo mysql_error();

//or die("Database Connection Failed");
$selectdb=mysql_select_db($dbname) or 
die("Database could not be selected"); 
$result=mysql_select_db($dbname)
or die("database cannot be selected <br>");

// Fetch Record from Database

$output = "";
$table = "long_data1"; // Enter Your Table Name 
$sql = mysql_query("select * from $table");
$columns_total = mysql_num_fields($sql);

// Get The Field Name

/*for ($i = 0; $i < $columns_total; $i++) {
$heading = mysql_field_name($sql, $i);
$output .= '"'.$heading.'",';
}
$output .="\n";
*/


// Get Records from the table

while ($row = mysql_fetch_array($sql)) {
for ($i = 0; $i < $columns_total; $i++) {
$output .='"'.$row["$i"].'",';
}
$output .="\n";
}
#mysqli_close();
//echo "<hr>";

// Download the file
//$getdate = date("d-m-Y");


$filename = "long_data.csv";

$file = fopen("/home/pi/ntz/db_backup/long_data.csv","a+");

//header('Content-type: application/csv');
//header('Content-Disposition: attachment; filename='.$filename);

fwrite($file,$output);

fclose($file);

// Truncate Table (clears table)
include 'connect.php';
$sql = "TRUNCATE TABLE `long_data1`;";

mysqli_query($con,$sql);
mysqli_close($con);

exit;

?>
