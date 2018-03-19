<?php

        $dbuser   = "thomaspi";

        $con2      = mysqli_connect($dbserver,$dbuser,$dbpw,$dbname);

        if (!$con2){
                echo("Connection failed! " . mysqli_connect_error());
        }
?>
