<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <title>Raspberry Pi Gpio</title>
        <style>
        @import url(http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold&subset=latin);
		html, body {width:100%;height:100%;margin:0px;padding:0px;border:0px;font-family: 'Droid Sans';background-color:#111;color:#fff}
		#button_holder,#button_label {padding:5px;border:1px solid #7af;font-size:18pt;font-weight:bold;}
		#button_label {display: flex;justify-content: space-between;}
		.clear {clear:both;}
		#button_name {width:450px;height: 80px;line-height:80px;}
		.button_change_r {background:#450000;width:100%;text-align:center;height: 80px;line-height:80px;}
		.button_change_g {background:#003f00;width:100%;text-align:center;height: 80px;line-height:80px;}
        </style>
    </head>
 
    <body style="background-color: #333;">
    <!-- On/Off button's picture -->
    
	<?php
	$val_array = array(0,0,0,0,0);
	$relais_namen = array("Heizkörper","Fußboden","Lade","Zirkulations","Therme");
	//this php script generate the first page in function of the file
	for ($i= 0; $i<=4; $i++) {
		if($i >= 1) {
		$i2 = $i+1;
		//set the pin's mode to output and read them
		system("gpio mode ".$i2." out");
		exec ("gpio read ".$i2, $val_array[$i], $return );
		}
	}
	//for loop to read the value
	$i = 0;
	echo ("<div id='button_holder'>");
	for ($i = 0; $i <= 4; $i++) {
		if($i >= 1) {
		$i2 = $i+1; 
		} else {
		$i2 = $i;
		}
		echo ("<div id='button_label'>");
		//if off
		if ($val_array[$i2][0] == 1 ) {
			echo ("<span id='button_name'>".$relais_namen[$i]." Pumpe </span><span id='button_change_".$i2."' class='button_change_r'> Aus </span>");
		}
		//if on
		if ($val_array[$i2][0] == 0 ) {
			echo ("<span id='button_name'>".$relais_namen[$i]." Pumpe </span><span id='button_change_".$i2."' class='button_change_g'> Ein </span>");
		}
		echo ("<div class='clear'></div></div>");
	
	}
		echo ("</div>");
	?>

	<!-- javascript -->
	<script src="gpio_read_script.js"></script>
	<script>
	setInterval(function(){
		change_pin (0);
		change_pin (2);
		change_pin (3);
		change_pin (4);
		change_pin (5);
	},
	1000)
	</script>
    </body>
</html>
