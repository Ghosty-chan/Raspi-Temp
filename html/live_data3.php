<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title> Live Temperaturen </title>
<link rel="stylesheet" href="style.css">
<!-- <meta http-equiv="refresh" content="1"> -->
<script type="text/javascript">
  var framefenster = document.getElementsByTagName("iFrame");
  var auto_resize_timer = window.setInterval("autoresize_frames()", 60000);
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
<?php
$uptime = exec("uptime");
echo "<h3> $uptime </h3><hr>";
$dirs= array_diff(scandir("./temps"), array("..","."));
$para='name="temps"';

foreach ($dirs as $key => $value) {
	$subpos = strpos($value,".");
	$subname = substr($value,$subpos);
	if ( $subname == ".php" ) {
	echo "<iframe src='./temps/$value' $para style='display:block;margin:0px;padding:0px;overflow:hidden;width:100%;height:auto;' hspace='0' marginheight='0' frameBorder='0'></iframe>";
	}
}
echo "<hr>";
echo "<table>";
echo "<hr>";
echo "</table>";
?>

</body>
</html>
