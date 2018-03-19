<?php
if(isset ( $_GET["pin"] ) && isset ( $_GET["values"]) && isset( $_GET["selector"])) {
	$pin = $_GET["pin"];
	$values = strip_tags ($_GET["values"]);
    $selector = $_GET["selector"];
    $pin_attach ="";
    function sql_query($sql_query) {
        include "connect.php";
        $result = mysqli_query($con,$sql_query);
        if (!$result){
            echo "Abfrage konnte nicht ausgeführt werden! \n $result \n " . mysqli_error($con);
        }
        mysqli_close($con);
        return $result;
    }
        if($selector == "0" || $selector == "1"){
            $pin_attach = "_RANGE";
            switch ($selector) {
                case 0:
                    $selector = "VALUE";
                    break;
                case 1:
                    $selector = "VALUE_2";
            }
        } else {
            $pin_attach = "_SCHEDULE";
            switch ($selector) {
                case "Son":
                    $selector = "VALUE";
                    break;
                case "Mon":
                    $selector = "VALUE_2";
                    break;
                case "Die":
                    $selector = "VALUE_3";
                    break;
                case "Mit":
                    $selector = "VALUE_4";
                    break;
                case "Don":
                    $selector = "VALUE_5";
                    break;
                case "Fre":
                    $selector = "VALUE_6";
                    break;
                case "Sam":
                    $selector = "VALUE_7";
                    break;
                default:
                    echo "$selector entspricht keiner Bedingung!";
                    $selector = "";
                    $pin_attach = "";
                    break;
            }
        }
    $sql = "UPDATE configs SET `".$selector."`='".$values."' WHERE `KEY_ID`='".$pin."".$pin_attach."'";
    #$sql = "UPDATE settings SET ".$pin."_RANGE='".$values."' WHERE ID=1";
	$result = sql_query($sql);

}

?>