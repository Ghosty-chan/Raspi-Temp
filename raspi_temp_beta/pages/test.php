<html>
<head>
<title> Test Page </title>
<style>
body {background-color:#333;color:#fff;}
.big_text { font-size:32pt; font-weight:bold;  }
</style>
</head>
<body>
<?php
## functions ##
function sommerzeitTest() {
	$data = date("I");
	return $data;
}
function uhrzeit() {
	$data = date("l , j.n.Y H:i:s");
	return $data;
}
function text_add($text) {
	$vorlage = "<h1> Test </h1><h3>";
	$vorlage = $vorlage . $text;
	$vorlage = $vorlage . "</h3>";
	return $vorlage;
}
function angefang_trennung($string,$pos_bei){
	$pos_bei = strpos($string, $pos_bei);
	$string = substr($string,0,$pos_bei);
	// Substr ( Text , Beginnende Stelle, Endene Stelle )
	return $string;
}
function end_trennung($string,$pos_bei){
	$pos_bei = strpos($string, $pos_bei)+1;
	$string = substr($string,$pos_bei);
	// Substr ( Text , Beginnende Stelle, Endene Stelle )
	return $string;
}
function fett_schreiben($ysfo) {
	$ysfo = "<span class='big_text'>" . $ysfo . "</span><br>";
	return $ysfo;
}
## execute ##
	fett_schreiben(angefang_trennung("Hallo, Welt!",","));
	fett_schreiben(end_trennung("Hallo Walter!, dies ist nun dein Text",","));
?>
</body>
</html>