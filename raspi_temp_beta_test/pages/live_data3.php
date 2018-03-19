<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" / >
<title> Live Temperaturen </title>
<meta name="viewport" content="initial-scale=0.5" />
<link rel="stylesheet" href="../conf/styles/live_style.css">



</head>
<body>
  <div id="container">
    <!--<a href='../index.php' style='position:absolute;top:0px;right:0px;:height:25px;width:100px;border-radius:25px;padding:2px 5px 2px 5px;background-color:#ddd;color:#000;text-decoration:none;text-align:center;'> Startseite </a>-->
    <div id="frame_list">
    <?php
    $dirs= array_diff(scandir("./temps"), array("..","."));
    $para='name="temps"';

    foreach ($dirs as $key => $value) {
    	$subpos = strpos($value,".");
    	$subname = substr($value,$subpos);
    	if ( $subname == ".php" ) {
    	echo "<div class='frame_item'><iframe id='frame_group".$key."' src='./temps/$value' $para hspace='0' marginheight='0' frameBorder='0' class='frame_holder'></iframe></div>";
    	}
    }
    ?>
    </div>
  </div>
  <script src="../conf/scripts/jquery.js"></script>
  <script src="../conf/scripts/fnc_live_data.js"></script>
</body>
</html>
