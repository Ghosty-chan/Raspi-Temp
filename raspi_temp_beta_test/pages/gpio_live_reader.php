<?php
//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//This page is requested by the JavaScript, it updates the pin's status and then print it
//Getting and using values
if (isset ( $_GET["pic"] )) {
    $pic = strip_tags ($_GET["pic"]);
    
    //test if value is a number
    if ( (is_numeric($pic)) ) {
        //reading pin's status
        exec ("gpio read ".$pic, $status, $return );
        //print it to the client on the response
        echo($status[0]);
        
    }
    else { echo ("fail"); }
} //print fail if cannot use values
else { echo ("fail"); }
?>
