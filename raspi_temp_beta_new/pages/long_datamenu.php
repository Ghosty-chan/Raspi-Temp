<!DOCTYPE html>
<html>
<head>
<title> Index - Raspberry </title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../bootstrap/css/font-awesome.min.css" rel="stylesheet">
<link href="../conf/styles/long_style.css" rel="stylesheet">
<link href="../conf/styles/custom.css" rel="stylesheet">
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
<!-- Important needs to stay here -->
<script src="../bootstrap/js/jquery.min.js"></script>
<!-- // -->
</head>
<body>
<div id="wrapper">
    <!-- NavBar -->
    <div id="sidebar-wrapper">
      <a href="#menu-toggle" class="test" id="menu-toggle">
        <ul class="sidebar-nav">
        <li class="sidebar-brand">
          <a href="../index.php">
            <img src="../conf/icon/raspi.png" class="button_icon"></img> RaspiTemp </a>
        </li>

        <?php
            $dirs = array_diff(scandir("."), array("..","."));
            $dirs_right = array();
        $dir_names = array();
        $dir_names_right = array();
        $dir_names_left = array();



            foreach ($dirs as $key => $value) {
                $subpos = strpos($value,".");
                $subname = substr($value,$subpos);
                $subval = substr($value,0,-4);
                if( $subname == ".php") {
                    if ($subval != "settings" & $subval != "phpmyadmin_forward") {
                    echo "<li><a href='$value' id='sidebar_$subval'> </a></li>";
          array_push($dirs_left,$value);
          array_push($dir_names_left,$subval);
                    } elseif ($subval == "settings" | $subval == "phpmyadmin_forward") {
                        array_push($dirs_right,$value);
            array_push($dir_names_right,$subval);
                    }
          array_push($dir_names,$subval);
                }
            }
            echo "</ul><ul class='sidebar-nav sidebar-bottom'>";

            foreach($dirs_right as $key => $value) {
                $subpos = strpos($value,".");
                $subname = substr($value,$subpos);
                $subval = substr($value,0,-4);
                echo "<li><a href='$value' id='sidebar_$subval'> </a></li>";
            }
        ?>
    </ul>
    </a>
    </div>
    <div id="page-content-wrapper">
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
    </div>
    <!-- Bootstrap Scripts -->
    <script src="../bootstrap/js/tether.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../conf/scripts/sidebarchanger.js"></script>
    <!-- Custom Scripts -->
    
    <?php
      $index="home";
      $live_data3="refresh";
      $long_datamenu="line-chart";
      $long_datamenu_remote="cloud";
      $phpmyadmin_forward="database";
      $settings="wrench";

      echo "<script type='text/javascript'>window.onload = function()
        {      
        $('#menu-toggle').click(function(e) {
        e.preventDefault();
        $('#wrapper').toggleClass('toggled');
        setTimeout(changeSidebar(), 1000);
        });

        function changeSidebar() {sidebar_width = document.getElementById('sidebar-wrapper').offsetWidth;if (sidebar_width == 75) {";
      foreach ($dir_names as $key => $value) {
        if(strlen($value) > 0) {
        $img_template = "document.getElementById('sidebar_$value').innerHTML = '";
        if ($value == "live_data3") {
        $img_template = $img_template . '<i class="fa fa-fw fa_icon fa-spin fa-'."${$value}".'" aria-hidden="true"></i>';
        } else {
        $img_template = $img_template . '<i class="fa fa-fw fa_icon fa-'."${$value}".'" aria-hidden="true"></i>';
        }
        $img_template = $img_template . "  $value"."';";
        echo "$img_template";
        }
      
      }
      echo "} else {";
      foreach ($dir_names as $key => $value) {
        if(strlen($value) > 0) {
        $img_template = "document.getElementById('sidebar_$value').innerHTML = '";
        #$img_template = $img_template.'<img src="conf/icon/settings.png" class="button_icon"></img>';
        #$img_template = $img_template."'".';';
        if ($value == "live_data3") {
        $img_template = $img_template . '<i class="fa fa-fw fa-spin fa_icon fa-'."${$value}".'" aria-hidden="true"></i>'."';";
        } else {
        $img_template = $img_template . '<i class="fa fa-fw fa_icon fa-'."${$value}".'" aria-hidden="true"></i>'."';";
        }
        echo "$img_template";
        }
      }
     
      echo "}};changeSidebar()};</script>";
    ?>
  </body>
</html>
