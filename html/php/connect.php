<?php

        $dbserver = "localhost";
        $dbuser   = "user";
        $dbpw     = "password";
        $dbname   = "database";

        $con      = mysqli_connect($dbserver,$dbuser,$dbpw,$dbname);

        if (!$con){
                echo("Connection failed! " . mysqli_connect_error());
        }
?>
