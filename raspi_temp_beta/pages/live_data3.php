<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" / >
<title> Live Temperaturen </title>
<meta name="viewport" content="width=800" />
<link rel="stylesheet" href="../conf/styles/live_style.css">



</head>
<body>
  <div id="container">
    <!--<a href='../index.php' style='position:absolute;top:0px;right:0px;:height:25px;width:100px;border-radius:25px;padding:2px 5px 2px 5px;background-color:#ddd;color:#000;text-decoration:none;text-align:center;'> Startseite </a>-->
    <ul id="frame_list">
    <?php
    $dirs= array_diff(scandir("./temps"), array("..","."));
    $para='name="temps"';

    foreach ($dirs as $key => $value) {
    	$subpos = strpos($value,".");
    	$subname = substr($value,$subpos);
    	if ( $subname == ".php" ) {
    	echo "<li class='frame_item'><iframe id='frame_group".$key."' src='./temps/$value' $para style='display:block;margin:0px;padding:0px;overflow:hidden;width:250px;height:350px;' hspace='0' marginheight='0' frameBorder='0' class='frames'></iframe></li>";
    	}
    }
    ?>
    </ul>
  </div>
  <script src="../conf/scripts/jquery.js"></script>
  <script src="../conf/scripts/fnc_live_data.js"></script>
</body>
</html>
