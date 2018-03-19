<?php
	$i = 0;
while(true){
	unset($status);
	unset($status2);
	unset($return);
	exec("gpio read 4",$status,$return);
	exec("gpio read 25",$status2,$return);
	echo $i."  ".date("D M j G:i:s T Y")." - Input: ".$status[0]." | Output: ".$status2[0]."\n";
	sleep(10);
	$i = $i + 1;
}
?>