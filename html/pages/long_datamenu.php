<!DOCTYPE html>
<html>
<head>
<title> Index - Raspberry </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,  user-scalable = no"> 
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript">
  var framefenster = document.getElementsByTagName("iFrame");
  var auto_resize_timer = window.setInterval("autoresize_frames()", 400);
  function autoresize_frames() {
    for (var i = 0; i < framefenster.length; ++i) {
        if(framefenster[i].contentWindow.document.body){
          var framefenster_size = framefenster[i].contentWindow.document.body.offsetHeight;
          if(document.all && !window.opera) {
            framefenster_size = framefenster[i].contentWindow.document.body.scrollHeight;
          }
          framefenster[i].style.height = framefenster_size + 'px';
        }
    }
  }
window.onload = function () {  autoresize_frames() }
</script>

</head>
<body>
<div id="container">
	<div id="checkfields">
		<?php

	include 'php/connect.php';
	
	$longdata_names = array();
	
	$sql = "SHOW COLUMNS FROM long_data1";
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result)){
		if( $row['Field'] != "ID" & $row['Field'] != "Datum") {
			array_push($longdata_names,$row['Field']);
		}
	}
	
	
	
	
	mysqli_close($con);
	foreach ($longdata_names as $key => $value) {
		echo "<div id='check_long'><input type='checkbox' name='sensoren[]' value='$value' id='test'> $value </div>";
		
	}

	
		?>
	</div>
	<div style="clear:both;">
	<br>
	<a href='index.php' style='height:25px;width:100px;border-radius:25px;padding:2px 20px 2px 20px;background-color:#ddd;color:#000;text-decoration:none;margin:0px 0px 0px 75%;'> Startseite </a>
	</div>
	<hr>	<hr>
		<!--iframe name='longdata_frame' src='php/test.html' style='display:block;margin:0;padding:0;overflow:hidden;width:100%;' hspace='0' marginheight='0' frameBorder='0' height='800px'></iframe>-->
	<?php
		include 'php/long_data.php';
	?>
	
</div>
</body>
</html>
