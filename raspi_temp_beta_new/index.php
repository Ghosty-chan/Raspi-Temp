<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> RaspiTemp - Index </title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/css/font-awesome.min.css">
    <link href="conf/styles/indexstyle.css" rel="stylesheet">
    <link href="conf/styles/custom.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div id="wrapper">
  	<!-- NavBar -->
  	<div id="sidebar-wrapper">
      <a href="#menu-toggle" class="test" id="menu-toggle">
    	<ul class="sidebar-nav">
        <li class="sidebar-brand">
          <a href="index.php">
            <img src="conf/icon/raspi.png" class="button_icon"></img> RaspiTemp </a>
        </li>

    	<?php
    		$dirs = array_diff(scandir("./pages"), array("..","."));
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
					echo "<li><a href='pages/$value' id='sidebar_$subval'> </a></li>";
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
				echo "<li><a href='pages/$value' id='sidebar_$subval'> </a></li>";
			}
		?>
    </ul>
    </a>
    </div>
    <div id="page-content-wrapper">
    <div class="container">
    	<div class="main_content">
			<h1> Dashboard </h1>
			<?php
				echo "<h4> ".date("l , j.n.Y H:i:s")." </h4>"
			?>

		  </div>
    </div>
    </div>
<!-- /#wrapper -->
</div>
    <!-- Bootstrap Scripts -->
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/tether.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="conf/scripts/sidebarchanger.js"></script>
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