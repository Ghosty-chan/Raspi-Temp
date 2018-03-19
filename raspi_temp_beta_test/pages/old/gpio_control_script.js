//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//JavaScript, uses pictures as buttons, sends and receives values to/from the Rpi
//These are all the buttons
var button_0 = document.getElementById("button_change_0");
var button_1 = document.getElementById("button_change_1");
var button_2 = document.getElementById("button_change_2");
var button_3 = document.getElementById("button_change_3");

//Create an array for easy access later
var Buttons = [ button_0, button_1, button_2, button_3];

//This function is asking for gpio.php, receiving datas and updating the index.php pictures
function change_pin ( pic, change ) {
var data = 0;
//send the pic number to gpio.php for changes
//this is the http request
	var request = new XMLHttpRequest();
	if ( change == 1) {
	request.open( "GET" , "gpio_controller.php?chg=1&pic=" + pic, true);
	} else {
	request.open( "GET" , "gpio_controller.php?chg=0&pic=" + pic, true);
	}
	request.send(null);
	//receiving informations
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			data = request.responseText;
			//update the index pic
			if ( !(data.localeCompare("0")) ){
				Buttons[pic-22].className = "button_change_r";
				Buttons[pic-22].innerHTML = " Aus ";
			}
			else if ( !(data.localeCompare("1")) ) {
				Buttons[pic-22].className = "button_change_g";
				Buttons[pic-22].innerHTML = " Ein ";
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