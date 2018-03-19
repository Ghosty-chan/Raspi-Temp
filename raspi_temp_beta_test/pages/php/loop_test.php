<?php
	$timer_start = microtime(true);
	$time_soll_vergangen = 60 * 1; // 5 Minuten

		while (true) {
		// Loop till 5 Mins or Zirk > WW_Sp
		$timer_end = microtime(true);
		$time_vergangen = $timer_end - $timer_start;

			if ( $time_vergangen > $time_soll_vergangen ) {
				echo "Break - ".$time_vergangen;
				break;

			} else {
				echo "Wait - ".$time_vergangen;
				sleep(10);
			}
		}
		echo ("Zirk Pumpe ausgeschalten");

?>