<!DOCTYPE html>
<html>
<head>
<title> Index - Raspberry </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,  user-scalable = no"> 

<?php 
	if(!empty($_COOKIE['_theme'])) $style = $_COOKIE['_theme'];
	else $style = "none";
?>
<link id="hoja_estilo" rel="stylesheet" href="conf/styles/index<?php echo "$style" ?>.css" type="text/css" media="screen" />
<!--<link rel="stylesheet" type="text/css" href="conf/styles/indexstyle.css">-->
<script src="conf/scripts/jquery.js"></script>
<script>
	$( document ).ready(function() {
		$("body").fadeOut(0, function() {
			$("li").fadeOut(0, function() {
				$("body").fadeIn(1000, function() {
					$("li").each(function(index) {
						$(this).delay(400*index).fadeIn(1000);
					});
				});
			});
		});
		
		$(".a_buttons").hover(function() {
			$(this).children(".button_icon").slideDown();
		}, function() {
			$(this).children(".button_icon").slideUp();
		});
	});
/*
  
	$("body").fadeOut(0).fadeIn(5000);
	
  
 */
  $(document).ready(function(){
	
	// click en cualquier link </a> del contenedor #estilos
	$("#estilos a").click(function(){
		CargarCSS(this);
		return false;
	});
	
	function CargarCSS( CSSelegido ) {
		// obtener contenido del link </a> 
		// la variable async servira para identificar contenido asyncrono
		$.get( CSSelegido.href+'&async',function(data){
			// cambiarmos atributo href del elemento hoja_estilo, obtenido de theme.php
			$('#hoja_estilo').attr('href', data + '.css');
		});
	}
});
</script>
</head>
<body>
<div class="container">
	<div class="links">
		<?php
			$dirs= array_diff(scandir("./pages"), array("..","."));
			#$dirs2= array_diff(scandir("/var/www/html/temps"), array("..","."));
			#$dirs3= array_diff(scandir("/var/www/html/php"), array("..","."));

			echo "<div class='quick_all'>";
			echo "<ul class='menu_bar'> <li class='menu_bar_li_start'><a class='a_buttons'> raspi_temperatur <br><img src='conf/icon/raspi.png' class='button_icon'></img></a></li>";
			
			foreach ($dirs as $key => $value) {
				$subpos = strpos($value,".");
				$subname = substr($value,$subpos);
				$subval = substr($value,0,-4);
				if( $subname == ".php") {
					echo "<li class='menu_bar_li'><a href='$value' class='a_buttons'>$value <br><img src='conf/icon/$subval.png' class='button_icon'></img></a></li>";
				}
			}
			echo "</ul></div>";
                                echo "<script type='text/javascript'>";
				echo "function replaceWords() {document.getElementById('links').innerHTML = document.getElementById('links').innerHTML";
			$file = fopen("pages/php/indexsettings.txt","r") or die("Unable to open file!");
				while(!feof($file)){
					$line = fgets($file);
					$subpos = strpos($line,"-");
					$subname = substr($line,$subpos+1,-1);
					$sublink = substr($line,0,$subpos);
					$test .= "$subname - $sublink <br>";
				echo '.replace(">'.$sublink.'", ">'.$subname.'")';
				}
			fclose($file);
				echo ";} replaceWords();";
				echo "</script>";


		?>
			  <a class="color_change" href="theme.php?thm=style" style="background-color:#333;"></a> 
			  <a class="color_change" href="theme.php?thm=style2" style="background-color:#fff;"></a>
			  <a class="color_change" href="theme.php?thm=style3" style="background-color:#48f;"></a>	
	</div>
</div>
</body>
</html>
