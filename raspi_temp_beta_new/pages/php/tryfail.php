<?php
	// Date Variables for actual Date
	$curdate=date("j.n.Y");
	$dbdate=strtotime("+1 month", strtotime($curdate));
	$dbdate=date("F-Y", $dbdate);
	//
	echo "$curdate | $dbdate";

	//
	echo "<hr>";
	//
	for ($x = 0; $x <= 10; $x++) {
	    echo "The number is: $x <br>";
	}

	//
	echo "<hr>";
	//
	
?>