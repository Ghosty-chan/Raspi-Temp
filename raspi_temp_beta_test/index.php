<!DOCTYPE html>
<html>
<head>
<title> Index - Raspberry </title>
<meta charset="utf-8">
<meta name="viewport" content="width=600" />
<link rel="stylesheet" type="text/css" href="conf/styles/indexstyle.css">
<script src="conf/scripts/jquery.js"></script>
</head>
<body>
<div class="container">
	<div class="links">
		<?php
			$dirs= array_diff(scandir("./pages"), array("..","."));
			$hide_site = array("gpio_live_reader","gpio_grad_schaltung","beta_forward","test");
			#$dirs2= array_diff(scandir("/var/www/html/temps"), array("..","."));
			#$dirs3= array_diff(scandir("/var/www/html/php"), array("..","."));

			echo "<div class='quick_all'>";
			echo "<ul class='menu_bar'> <li class='menu_bar_li'><a class='a_buttons'> Raspi Home <br><img src='conf/icon/raspi.png' class='button_icon'></img></a></li>";

			foreach ($dirs as $key => $value) {
				$subpos = strpos($value,".");
				$subname = substr($value,$subpos);
				$subval = substr($value,0,-4);
				if( $subname == ".php") {
					if (!in_array($subval, $hide_site)) {
						echo "<li class='menu_bar_li'><a href='pages/$value' class='a_buttons'>$value <br><img src='conf/icon/$subval.png' class='button_icon'></img></a></li>";
					}
				}
			}
			echo "</ul></div>";
		?>
	</div>
</div>
</body>
</html>
