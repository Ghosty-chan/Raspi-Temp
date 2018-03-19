<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" / >
<title> Live Temperaturen </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../bootstrap/css/font-awesome.min.css" rel="stylesheet">
<link href="../conf/styles/live_style.css" rel="stylesheet">
<link href="../conf/styles/custom.css" rel="stylesheet">
<!-- <meta http-equiv="refresh" content="1"> -->


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
    <div class="container">
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
        echo "<li class='frame_item'><iframe src='./temps/$value' $para style='display:block;margin:0px;padding:0px;overflow:hidden;width:250px;height:350px;' hspace='0' marginheight='0' frameBorder='0' class='frames'></iframe></li>";
        }
    }
    ?>
    </ul>
    <div id="time_clock">
        <p id="time_clock_p">
        </p>
    </div>
    </div>
    </div>
    </div>
<!-- /#wrapper -->
</div>
  
    <!-- Bootstrap Scripts -->
    <script src="../bootstrap/js/jquery.min.js"></script>
    <script src="../bootstrap/js/tether.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../conf/scripts/sidebarchanger.js"></script>
    <!-- Custom Scripts -->
    <script src="../conf/scripts/custom.js"></script>
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
        echo "console.log(sidebar_width);";
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
