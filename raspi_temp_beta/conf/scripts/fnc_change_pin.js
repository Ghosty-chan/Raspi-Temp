//This function is asking for gpio.php, receiving datas and updating the index.php pictures
function change_pin ( elem, pic, gpio_in ) {
var data = 0;
//send the pic number to gpio.php for changes
//this is the http request
	var request = new XMLHttpRequest();
	request.open( "GET" , "gpio_live_reader.php?pic=" + pic, true);
	request.send(null);
	//receiving informations
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			data = request.responseText;
			//update the index pic
			if ( gpio_in ) {
				data_on = "1";
				data_off = "0";
			} else {
				data_on = "0";
				data_off = "1";
			}
			if ( pic == 12 ) {
				data_on = "0";
				data_off = "1";
			}

			if ( !(data.localeCompare(data_on)) ){
				if ( pic != 22 && pic != 23 && pic != 24) {
				elem.className = "button_change_r";
				elem.innerHTML = " Aus ";
				} else {
				elem.className = "buttons_bhzg button_change_r";
				elem.innerHTML = " Aus ";	
				}
			}
			else if ( !(data.localeCompare(data_off)) ) {
				if ( pic != 22 && pic != 23 && pic != 24) {
				elem.className = "button_change_g";
				elem.innerHTML = " Ein ";
				} else {
				elem.className = "buttons_bhzg button_change_g";
				elem.innerHTML = " Ein ";
				}
			}
			else if ( !(data.localeCompare("fail"))) {
				console.log("Something went wrong!" );
				return ("fail");			
			}
			else {
				console.log("Something went very wrong!" );
				return ("fail"); 
			}
		}
		//test if fail
		else if (request.readyState == 4 && request.status == 500) {
			console.log("server error");
			return ("fail");
		}
		//else 
		else if (request.readyState == 4 && request.status != 200 && request.status != 500 ) { 
			console.log("Something went wrong!");
			return ("fail"); }
	}	
	
return 0;
}
