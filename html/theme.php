<?php
$tema=$_GET['thm'];
setcookie('_theme',$tema,time()+(86400*365),"/","");
if(isset($_GET['async'])) {
	echo $tema;
}else{
	header("Location: ".$_SERVER['HTTP_REFERER']);
}
?>