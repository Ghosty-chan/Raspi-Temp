<!DOCTYPE html>
<html>
<head>
<title> Index - Raspberry </title>
<meta charset="utf-8">
<!--<meta name="viewport" content="width=400;" />-->
<link rel="stylesheet" href="../conf/styles/long_style.css">
<script type="text/javascript">
//  var framefenster = document.getElementsByTagName("iFrame");
//  var auto_resize_timer = window.setInterval("autoresize_frames()", 400);
//  function autoresize_frames() {
//    for (var i = 0; i < framefenster.length; ++i) {
//        if(framefenster[i].contentWindow.document.body){
//          var framefenster_size = framefenster[i].contentWindow.document.body.offsetHeight;
//          if(document.all && !window.opera) {
//            framefenster_size = framefenster[i].contentWindow.document.body.scrollHeight;
//          }
//          framefenster[i].style.height = framefenster_size + 'px';
//        }
//    }
//  }
    function recolor() {
    var checkboxes = document.getElementsByClassName("input_checkbox");

    for (var i = 0; i < checkboxes.length; ++i) {
        if(checkboxes[i].checked){
        checkboxes[i].parentNode.style.border='1px solid #478ae4';
        }
    }
    }
//window.onload = function () {  autoresize_frames() }

function doReload(checkbox) {
  if (checkbox.checked)
    { // checkbox.value
      document.forms["long_data"].submit();

    } else {
      document.forms["long_data"].submit();
    }
}

window.onload = function () {  recolor() }
</script>
</head>
<body>
<div id="container">
	<div id="checkfields">
    <form id="long_data" action="long_datamenu.php" method="POST">
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
    $checked="";
    if(isset($_POST["$value"])) {$checked="checked='checked'";}
    echo "<div class='check_long'><input type='checkbox' name='$value' value='$value' class='input_checkbox' onchange='doReload(this)' $checked ;> $value </div>";

    #echo $_POST[sensoren[]];
  	}
		?>
  </form>
	</div>
	<div style="clear:both;">
	<br>
	<!--<a href='../index.php' style=';position:absolute;top:0px;right:0px;:height:25px;width:90px;border-radius:25px;padding:2px 5px 2px 5px;background-color:#ddd;color:#000;text-decoration:none;text-align:center;'> Startseite </a>-->
	</div>
	<hr>
		<!--iframe name='longdata_frame' src='php/test.html' style='display:block;margin:0;padding:0;overflow:hidden;width:100%;' hspace='0' marginheight='0' frameBorder='0' height='800px'></iframe>-->
	<?php
    $temp_value = array();
  foreach ($_POST as $key => $value){
    array_push($temp_value, $value);
  }
		include 'php/long_data.php';
	?>

</div>
</body>
</html>
