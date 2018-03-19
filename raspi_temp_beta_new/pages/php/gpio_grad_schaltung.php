<?php
	exec('cat /sys/bus/w1/devices/w1_bus_master1/w1_master_slaves', $sensor_list_temp);

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
	$heute = date("D M j G:i:s T Y");
	$relais = ["22","23","24"];
	$ausen_temp = getData("28-0000074d5835");

	if($ausen_temp != "") {
			$ausen_temp = $ausen_temp;
			if ($ausen_temp <= 14) {
				$i = 0;
				for ($i = 0; $i < 3; $i++) {
				$mode = system("gpio mode ".$relais[$i]." out");
				exec ("gpio read ".$relais[$i], $status, $return );
				system("gpio write ".$relais[$i]." 1" );
				}
				echo "######################".PHP_EOL;
				echo "$mode".PHP_EOL;
				echo "".PHP_EOL;
				echo "Boden Heizung - Eingeschalten".PHP_EOL;
				echo "Außentemperatur: $ausen_temp".PHP_EOL;
				echo "".PHP_EOL;
			} elseif ($ausen_temp > 14) {
				$i = 0;
				for ($i = 0; $i < 3; $i++) {
				$mode = system("gpio mode ".$relais[$i]." out");
				exec ("gpio read ".$relais[$i], $status, $return );
				system("gpio write ".$relais[$i]." 0" );
				}
				echo "######################".PHP_EOL;
				echo "".PHP_EOL;
				echo "$heute".PHP_EOL;
				echo "Boden Heizung - Ausgeschalten".PHP_EOL;
				echo "Außentemperatur: $ausen_temp".PHP_EOL;
				echo "".PHP_EOL;
			} else {
				echo "######################".PHP_EOL;
				echo "".PHP_EOL;
				echo "$heute".PHP_EOL;
				echo "Fehler: Kein Ergebnis".PHP_EOL;
				echo "".PHP_EOL;
			}
	}

?>
