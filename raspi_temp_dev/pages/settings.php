<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" / >
<title> Settings </title>
<meta name="viewport" content="width=800" />
<link rel="stylesheet" href="../conf/styles/settings_style.css" />
</head>
<body>
  <div id="container">
  	<div id="settings_bar">
		<h2> Hellu </h2> <hr>
		<ul> <h3> Settings </h3>
			<li> Timer <br> push_long_time änderbar </li>
			<li> Timer <br> exportdb änderbar </li>
			<li> Temperaturen <br> Min - Default - Max </li>
			<li> Sensoren <br> Welche aufgezeichnet werden? </li>
			<li> Sensoren <br> Namen änderbar </li> 
		</ul>
		<hr>

		<?php 
			include 'php/settings/get_tables.php';
		?>
	</div>
  </div>
</body>
</html>
