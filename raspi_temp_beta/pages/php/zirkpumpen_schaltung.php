	<?php
		// While true - Abfrage des Relais dann Starte dieses File

		
		#exec('cat /sys/bus/w1/devices/w1_bus_master1/w1_master_slaves', $sensor_list_temp);
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
	while ( true ) {
		$heute = date("D M j G:i:s T Y");
		$ww_sp_austritt = getData("28-0000074c96de");
		$zirk_pumpe_temp = getData("10-0008032a4c96");
		$zirk_pumpe_eingang_pin = 4; // Pin 16 / GPIO 04
		$zirk_pumpe_ausgang_pin = 25; // Pin 37 / GPIO 25
		$time_soll_vergangen = 60 * 5; // 5 Minuten
		unset($zirk_pumpe_eingang);
		unset($zirk_pumpe_ausgang);
		unset($return);
		$array = array("");
		echo "\n".$heute;
		echo "\n";
		exec("gpio mode ".$zirk_pumpe_eingang_pin." in", $output, $return);
		exec("gpio mode ".$zirk_pumpe_ausgang_pin." out", $output, $return);
		exec("gpio read ".$zirk_pumpe_eingang_pin, $zirk_pumpe_eingang, $return);
		echo "zirk_pumpe_eingang_pin - ".$zirk_pumpe_eingang[0]." \n";
		exec("gpio read ".$zirk_pumpe_ausgang_pin, $zirk_pumpe_ausgang, $return);
		echo "zirk_pumpe_ausgang_pin - ".$zirk_pumpe_ausgang[0]." \n";
		while($zirk_pumpe_eingang[0] == "1" && $zirk_pumpe_ausgang[0] == "0") {
			unset($zirk_pumpe_eingang);
			exec("gpio read 4", $zirk_pumpe_eingang, $return);
			echo date("D M j G:i:s T Y")."  ";
			echo "1 | zirk_pumpe_eingang_pin - ".$zirk_pumpe_eingang[0]." \n";
			sleep(10);
		}
	if($zirk_pumpe_eingang[0] == "0" && !($zirk_pumpe_temp >= ($ww_sp_austritt-2))) {
	exec ("gpio write ".$zirk_pumpe_ausgang_pin." 1", $output, $return);
	echo ("Zirk Pumpe eingeschalten | ".$output[0]." \n");
		// Ausgeschalten - Schalte Ein wenn Zirk Pumpe Eingang 
		while ( $zirk_pumpe_eingang[0] == "0" && $zirk_pumpe_eingang[0] != "1") {
			unset($zirk_pumpe_eingang);
			$time_start = microtime(true);
			exec("gpio read ".$zirk_pumpe_eingang_pin, $zirk_pumpe_eingang, $return);
			echo date("D M j G:i:s T Y")."  ";
			echo "0 | zirk_pumpe_eingang_pin - ".$zirk_pumpe_eingang[0]." \n";
			sleep(10);
		}
	}
	if ( $zirk_pumpe_ausgang[0] == "1" && $zirk_pumpe_eingang[0] == "1") {
		// Eingeschalten - Wenn 5 Min oder Zirk_Pumpe über WW_Sp_Austritt dann Ausschalten
		while ($zirk_pumpe_ausgang[0] == "1") {
		// Loop till 5 Mins or Zirk > WW_Sp

		$time_end = microtime(true);
		$time_vergangen = $time_end - $time_start;
		$ww_sp_austritt = getData("28-0000074c96de");
		$zirk_pumpe_temp = getData("10-0008032a4c96");

			if ( $zirk_pumpe_temp >= ($ww_sp_austritt-2) OR $time_vergangen > $time_soll_vergangen ) {
				break;
			} else {
				sleep(10);
				echo "Waiting # ".$time_vergangen." - ".$ww_sp_austritt." | ".$zirk_pumpe_temp."\n";
			}
		}
		exec ("gpio write ".$zirk_pumpe_ausgang_pin." 0", $output, $return);
		echo ("Zirk Pumpe ausgeschalten | ".$output." | ".$return." \n");
	} else {
		echo ("Ausgang 0 \n");
	}
		sleep(5);
}
	sleep(10);
?>
