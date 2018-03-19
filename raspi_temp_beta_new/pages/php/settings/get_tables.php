<?php
    function sql_query($sql_query) {
        include "php/connect.php";
        $result = mysqli_query($con,$sql_query);
        if (!$result){
            echo "Abfrage konnte nicht ausgeführt werden! <br> # $result <br> # " . mysqli_error($con);
            exit;
        }
        mysqli_close($con);
        return $result;
    }
    $sql = "SHOW COLUMNS FROM basis";
    $result = sql_query($sql);

    $tableName=array();
    $data=array();


    while($row = mysqli_fetch_array($result)){
        array_push($tableName,$row['Field']);
    }
    
    $sql = "SELECT * FROM basis";
    $result = sql_query($sql);

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
            array_push($data,$row);
        }
    }

echo '<div id="gettable"><table> <h2> Sensoren </h2><thead><tr>';
        foreach ($tableName as $key => $value) {
        echo " <td> $value </td> ";
        }
echo '</tr></thead><tbody>';
        foreach ($data as $key => $value) {
        echo "<tr>";
            foreach($value as $key2 => $value2) {
                if ($key2 != "ID" AND $key2 != "Num") {
                echo "<td contenteditable> $value2 </td>";
                } else {
                echo "<td> $value2 </td>";
                }
            }
        echo "</tr>";
        }
echo '</tbody></table></div>';
?>