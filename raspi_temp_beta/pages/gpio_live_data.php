<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Raspberry Pi GPIO</title>
        <style>
        @import url(http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold&subset=latin);
        html, body {width:100%;height:100%;margin:0px;padding:0px;border:0px;font-family: 'Droid Sans';background-color:#111;color:#fff;font-size:16pt;}
        .button_holder{margin-bottom:5px;border:1px solid #7af;overflow:hidden;}
        .button_holder,#button_label {padding:5px;font-size:18pt;font-weight:bold;}
        #button_label {border-bottom:1px solid #444;}
        .clear {content:"";clear:both;display:table;}
        .button_name {width:500px;height: 65px;line-height:65px;float:left;padding-left:25px;}
        .button_name_bhzg {width:500px;height: 45px;line-height:45px;float:left; }
        .button_change {background:#7af;width:100%;text-align:center;height: 65px;line-height:65px;display:block;}
        .buttons_bhzg {height: 40px !important;line-height:40px !important;display:block;}
        .button_change_r {background:#450000;width:100%;text-align:center;height: 65px;line-height:65px;display:block;}
        .button_change_g {background:#003f00;width:100%;text-align:center;height: 65px;line-height:65px;display:block;}
        .ui-slider {height:20px;line-height:20px;margin-top:5px;}
        .ui-slider-handle {border-radius:100% !important;}
        .rangetext {font-weight:bold;color:#fff;text-align:center;margin-bottom:8px;}
        .rangetext::before {content:"Tag: ";font-size:0.85em;color:#fff;}
        .rangetext::after {content:"°C";font-size:0.85em;color:#fff;margin-left:8px;}
        .night_rangetext {font-weight:bold;color:#fff;text-align:center;margin-bottom:8px;}
        .night_rangetext::before {content:"Nacht: ";font-size:0.85em;color:#fff;}
        .night_rangetext::after {content:"°C";font-size:0.85em;color:#fff;margin-left:8px;}
        .collapse_toggle_off p::before {content:'+';font-size:18pt;border-radius:100%;padding:5px;text-align:center;}
        .collapse_toggle_on p::before {content:'-';font-size:18pt;border-radius:100%;padding:5px;text-align:center;}
        .collapse_toggle_off {border-radius:0px; border-bottom:0px;}
        .collapse_toggle_on {border-radius:0px 0px 25px 25px; border-bottom:3px solid #333;}
        .collapse_button {background-color:#0b0b0b;border-radius:0px;padding:5px 50px 5px 50px}
        .collapse_button p{text-align:center;font-size:18pt;font-weight:bold;letter-spacing: 0.15em;border-bottom:1px solid #fff;opacity:0.65;}
        .collapse_bar {background-color:#0b0b0b;padding:5px 50px 5px 50px;border-radius:0px 0px 25px 25px;display:none;}
        .button_name + span {border-radius:25px;}
        .button_name_bhzg + span {border-radius:25px 25px 0px 0px;}
        .day-schedule-selector::before {content:'Tagschaltung';font-size:1.25em;font-weight:bold;text-align:center;margin:0 auto;display:block;padding:15px 0px 0px 0px;}
        .schedule-table {margin:0 auto;padding:15px 0px 5px 0px;}
        
        .schedule-header th:first-child::after {content:'';}
        .schedule-rows td {width: 80px;height: 10px;margin: 3px;padding: 5px;background-color: #444;cursor: pointer;border-radius:5%;transition:0.25s all;}
        .schedule-rows td:first-child {background-color: transparent;text-align: right;}
        .schedule-rows td[data-selected],.schedule-rows td[data-selecting] { background-color: #7af; }
        .schedule-rows td[data-disabled] { opacity: 0.55; }
        .schedule_reset_button {border:1px solid #7af;background-color:#333;color:#fff;border-radius:5%;text-align:center;font-size:0.95em;margin-top:5px;}
        #button_hrefs {
            display: none;
            position: fixed;
            right: 5px;
            top: 5px;
            background-color: #252525;
            border: 1px solid #454545;
            overflow: hidden;
            padding: 5px;
            border-radius: 5px;
        }
        .icon_img {
            width: 50px;
            height: 50px;
            border-radius: 25px;
            margin: 0px;
            padding: 0px;
            border-radius: 25px;
        }
        </style>
        <link href="../conf/styles/jquery-ui.css" rel="stylesheet">
    </head>
 
    <body>
        <div id="button_hrefs">
            <button type="button" onclick="openLink('gpio_live_control.php');"><img src="../conf/icon/settings.png" class="icon_img"></button>
        </div>
    <?php

    function sql_query($sql_query) {
        include "php/connect.php";
        $result = mysqli_query($con,$sql_query);
        if (!$result){
            echo "Abfrage konnte nicht ausgeführt werden! <br> # $result <br> # " . mysqli_error($con);
        }
        mysqli_close($con);
        return $result;
    }
    $gpio_pins = array();
    $gpio_names = array();
    $gpio_ios = array();
    $gpio_status = array();
    $sql = "SELECT * FROM basis_gpio";
    $result = sql_query($sql);
    while($row = mysqli_fetch_array($result)){
        array_push($gpio_pins,$row['Pin']);
        array_push($gpio_names,$row['Name']);
        array_push($gpio_ios,$row['IO']);
    }
    // Output
    echo ("<div class='button_holder'>");
    //echo ("<div class='button_header'>")
    foreach($gpio_names as $key => $value) {
        if($gpio_ios[$key] == "OUT") {
            echo ("<div id='button_label'>");
            if(substr($gpio_names[$key], 0, 4) == "BHZG") {
            echo ("<span class='button_name_bhzg button_name'> $gpio_names[$key] | $gpio_ios[$key] </span><span id='button_change_".$gpio_pins[$key]."' class='buttons_bhzg button_change'> - - </span>");
            echo ("<div class='collapse_button collapse_toggle_off' id='collapse_button_".$gpio_pins[$key]."'><p> Eigenschaften (TEST) </p></div>");
            echo ("<div class='collapse_bar' id='collapse_bar_".$gpio_pins[$key]."'>");
            echo ("<div class='sliders' id='range_".$gpio_names[$key]."'></div><div class='rangetext' id='rangetext_".$gpio_names[$key]."'></div>");
            echo ("<div class='sliders_night' id='night_range_".$gpio_names[$key]."'></div><div class='night_rangetext' id='night_rangetext_".$gpio_names[$key]."'></div>");
            echo ("<div id='bhzg_schedule_".$gpio_pins[$key]."'></div>");
            echo ("</div>");
            } else {
            echo ("<span class='button_name'> $gpio_names[$key] | $gpio_ios[$key] </span><span id='button_change_".$gpio_pins[$key]."' class='button_change'>");
            }
            echo ("<div class='clear'></div></div>");
        }
    }
    echo ("</div>");
    // Input
    echo ("<div class='button_holder'>");
    foreach($gpio_names as $key => $value) {
        if($gpio_ios[$key] == "IN") {
            echo ("<div id='button_label'>");
            echo ("<span class='button_name'> $gpio_names[$key] | $gpio_ios[$key] </span><span id='button_change_".$gpio_pins[$key]."' class='button_change'> - - </span>");
            echo ("<div class='clear'></div></div>");
        }
    }
    echo ("</div>");
    ?>

    <!-- javascript -->
    <script src="../conf/scripts/jquery.js"></script>
    <script src="../conf/scripts/jquery-ui.js"></script>
    <script src="../conf/scripts/schedule.js"></script>
    <script>
        var Buttons = [];
    <?php
        function getSliderValues($range_name) {
            $sql = "SELECT * FROM `configs` WHERE `KEY_ID` = '".$range_name."_RANGE'";
            #$sql = "SELECT ".$range_name."_RANGE FROM settings";
            $result = sql_query($sql);
            return $result; 
        }
        function getScheduleValues($schedule_name) {
            $sql = "SELECT * FROM `configs` WHERE `KEY_ID` = '".$schedule_name."_SCHEDULE'";
            $result = sql_query($sql);
            return $result;
        }
        // Create Sliders
        foreach($gpio_names as $key => $value) {
            if(substr($value, 0, 4) == "BHZG" && !strpos(substr($value,4), "Schaltung" )){
            $slider_values = getSliderValues("$gpio_names[$key]");
            $slider_values = mysqli_fetch_assoc($slider_values);
            $slider_day_values = $slider_values["VALUE"];
            $slider_night_values = $slider_values["VALUE_2"];
            echo ('var slidetext_'.$value.' = $("#rangetext_'.$value.'");');
            echo ('var night_slidetext_'.$value.' = $("#night_rangetext_'.$value.'");');
            echo ('$( "#range_'.$value.'" ).slider({range: true, min: 20, max: 30, step: 0.1, animate: "slow", values: ['.$slider_day_values.'], create: function() { slidetext_'.$value.'.text( $(this).slider( "values" ) );},slide: function( event, ui) {slidetext_'.$value.'.text( ui.values );},stop: function( event, ui ) {change_db_settings("'.$gpio_names[$key].'", $(this).slider( "values" ), 0);}});');
            echo ('$( "#night_range_'.$value.'" ).slider({range: true, min: 15, max: 30, step: 0.1, animate: "slow", values: ['.$slider_night_values.'], create: function() { night_slidetext_'.$value.'.text( $(this).slider( "values" ) );},slide: function( event, ui) {night_slidetext_'.$value.'.text( ui.values );},stop: function( event, ui ) {change_db_settings("'.$gpio_names[$key].'", $(this).slider( "values" ), 1);}});');
            }
        }
        // Create JS Button vars
        foreach($gpio_pins as $key => $value) {
            echo ('var button_'.$value.' = document.getElementById("button_change_'.$value.'");');
            echo PHP_EOL;
            echo ('Buttons.push("button_'.$value.'");');
            echo PHP_EOL;
            if(substr($gpio_names[$key], 0, 4) == "BHZG" && !strpos(substr($gpio_names[$key],4), "Schaltung" )){
                echo ("$('#collapse_button_".$value."').click(function(){");
                echo PHP_EOL;
                echo ("$('#collapse_button_".$value."').toggleClass('collapse_toggle_off collapse_toggle_on');");
                echo ("$('#collapse_bar_".$value."').slideToggle('slow')});");
                echo PHP_EOL;
                // AND SCHEDULES!
                //$schedule_values = getSliderValues("$gpio_names[$key]");
                echo('$("#bhzg_schedule_'.$value.'").dayScheduleSelector({startTime   :"00:00",endTime     :"24:00",interval    :"30",stringDays  :["Son","Mon","Die","Mit","Don","Fre","Sam"],});');
                echo('$("#bhzg_schedule_'.$value.'").on("selected.artsy.dayScheduleSelector", function (e, selected) {var schedule_day = selected[0].attributes[2].nodeValue;var schedule_all = document.querySelectorAll("[data-day='."'".'"+schedule_day+"'."'".'][data-selected=selected]");var schedule_start = schedule_all[0].attributes[1].nodeValue;var schedule_end = schedule_all[(schedule_all.length-1)].attributes[1].nodeValue;var selected_time = schedule_start + "," + schedule_end;change_db_settings("'.$gpio_names[$key].'",selected_time,dayToString(schedule_day))});');

                $schedule_values = getScheduleValues("$gpio_names[$key]");
                $schedule_values = mysqli_fetch_assoc($schedule_values);
                for ($i = 1; $i <= 7; $i++) {
                    if($i == 1) {
                        $cur_day = $schedule_values["VALUE"];
                    } else {
                        $cur_day = $schedule_values["VALUE_".$i];
                    }
                        $start_mark = subStr($cur_day,0,strPos($cur_day,","));
                        $end_mark = subStr($cur_day,strPos($cur_day,",")+1);
                    echo ('$("#bhzg_schedule_'.$value.'").data('."'artsy.dayScheduleSelector').deserialize({'".($i-1)."': [['".$start_mark."','".$end_mark."']]});");
                    //echo 'console.log("'.$cur_day.' | '.$start_mark.' | '.$end_mark.' ");';
                }

            }
        }
        // Time for Interval
            echo ('var chgPinRefresh = setInterval(function(){');
        foreach($gpio_pins as $key => $value) {
            if($gpio_ios[$key] == "IN"){
                $gpio_in = 1;
            } else {
                $gpio_in = 0;
            }
            echo ('change_pin (button_'.$value.','.$value.','.$gpio_in.');');
            echo PHP_EOL;
        }
            echo ('}, 1000);');
            echo PHP_EOL;
    ?>
        function change_db_settings ( pin, values, dn ) {
            // DN = Day / Night ( 0 / 1 )
            var data = 0;
            var request = new XMLHttpRequest();
            var selector = dn;
            request.open("GET", "php/update_db_settings.php?pin="+pin+"&values="+values+"&selector="+selector,true)
            request.send(null);
            request.onreadystatechange = function () {
                console.log("Data changed: "+pin+" ; "+values+" ; "+selector+" | "+this.responseText);
            }
        }
        // Schedule
        function dayToString ( day ) {
            var weekday = new Array(7);
            weekday[0] = "Son";
            weekday[1] = "Mon";
            weekday[2] = "Die";
            weekday[3] = "Mit";
            weekday[4] = "Don";
            weekday[5] = "Fre";
            weekday[6] = "Sam";
            if(day >= 0 && day < 7) {
                return weekday[day];
            } else {
                return "Error";
            }
        }
        function openLink ( link ) {
            var cururl = window.location.href;
            var lastslash = cururl.lastIndexOf("/",-1);
            var cururl = cururl.substr(0,cururl.lastslash);
            window.open(cururl + link);
        }
        //openLink('gpio_live_control.php')
        // SCHOOL DEV 
        //clearInterval(chgPinRefresh);
    </script>
    <script src="../conf/scripts/fnc_change_pin.js"></script>
    </body>
</html>
