<!DOCTYPE html>
<html>
<head>
<title> Index - Raspberry </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,  user-scalable = no"> 
<link rel="stylesheet" type="text/css" href="indexstyle.css">
</head>
<body>
<div id="container">
	<div id="links">
		<?php
			$dirs= array_diff(scandir("."), array("..","."));
			#$dirs2= array_diff(scandir("/var/www/html/temps"), array("..","."));
			#$dirs3= array_diff(scandir("/var/www/html/php"), array("..","."));

			echo "<div id='quick_all'>";
			foreach ($dirs as $key => $value) {
				$subpos = strpos($value,".");
				$subname = substr($value,$subpos);
				$subval = substr($value,0,-4);
				if( $subname == ".php") {
					echo "<a href='$value' id='a_buttons'><div id='buttons'>$value <hr> <img src='icon/$subval.png' style='margin:5px;width:80%;height:80%;'></div></a>";
				}
			}
			echo "</div>";
			echo "<div id='php_all'>";
                        foreach ($dirs3 as $key => $value) {
                                $subpos = strpos($value,".");
                                $subname = substr($value,$subpos);
                                if( $subname == ".php") {
                                        echo "<a href='/php/$value' id='a_buttons'><div id='buttons'>$value</div></a>";
                                }
                        }
                        echo "</div>";
			echo "<div id='temps_all'>";
			foreach ($dirs2 as $key => $value) {
				$subpos = strpos($value,".");
				$subname = substr($value,$subpos);
				if( $subname == ".php" ) {
					echo "<a href='/temps/$value' id='a_buttons'><div id='buttons'>$value</div></a>";
				}
			}
			
			echo "</div>";
                                echo "<script type='text/javascript'>";
				echo "function replaceWords() {document.getElementById('links').innerHTML = document.getElementById('links').innerHTML";
			$file = fopen("php/indexsettings.txt","r") or die("Unable to open file!");
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
			echo "<hr>";

		?>
				
	</div>
</div>
</body>
</html>
