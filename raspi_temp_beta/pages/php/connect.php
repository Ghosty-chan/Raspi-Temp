<?php

        $dbserver = "localhost";
        $dbuser   = "root";
        $dbname   = "sensoren";

        $con      = mysqli_connect($dbserver,$dbuser,$dbpw,$dbname);

        if (!$con){
                echo("Connection failed! " . mysqli_connect_error());
                exit;
        }
?>
