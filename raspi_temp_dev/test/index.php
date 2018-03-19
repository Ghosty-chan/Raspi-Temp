<html>
<head>
<title> Test Ajax </title>
<meta charset="utf-8">
<script>
function getTime() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		document.getElementById("time_placeholder").innerHTML = this.responseText;
	};
		xmlhttp.open("GET","apax.php?",true);
		xmlhttp.send();
}


</script>
</head>
<body>
<h1> Ajax Test Page </h1>
<h4> Actual Time: <span id="time_placeholder"></span> </h4>
<button onClick="getTime()"> Get Time </button>
</body>
</html>
