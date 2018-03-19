//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//JavaScript, uses pictures as buttons, sends and receives values to/from the Rpi
//These are all the buttons

//Create an array for easy access later
var button_0 = document.getElementById("button_change_0");
var button_1 = document.getElementById("button_change_1");
var button_2 = document.getElementById("button_change_2");
var button_3 = document.getElementById("button_change_3");
var button_4 = document.getElementById("button_change_4");
var button_5 = document.getElementById("button_change_5");
var Buttons = [button_0, button_1, button_2, button_3, button_4, button_5];

//This function is asking for gpio.php, receiving datas and updating the index.php pictures
function change_pin ( pic ) {
var data = 0;
//send the pic number to gpio.php for changes
//this is the http request
	var request = new XMLHttpRequest();
	request.open( "GET" , "gpio_reader.php?pic=" + pic, true);
	request.send(null);
	//receiving informations
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			data = request.responseText;
			//update the index pic
			if ( !(data.localeCompare("1")) ){
				Buttons[pic].className = "button_change_r";
				Buttons[pic].innerHTML = " Aus ";
			}
			else if ( !(data.localeCompare("0")) ) {
				Buttons[pic].className = "button_change_g";
				Buttons[pic].innerHTML = " Ein ";
			}
			else if ( !(data.localeCompare("fail"))) {
				console.log("Something went wrong!" );
				return ("fail");			
			}
			else {
				console.log("Something went wrong!" );
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
