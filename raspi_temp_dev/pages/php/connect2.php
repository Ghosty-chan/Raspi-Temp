<?php

        $dbserver = "backup_db_ip";
        $dbuser   = "thomaspi";
        $dbpw     = "dbpw";
        $dbname   = "raspi-temp-bk";

        $con2      = mysqli_connect($dbserver,$dbuser,$dbpw,$dbname);

        if (!$con2){
                echo("Connection failed! " . mysqli_connect_error());
        }
?>
