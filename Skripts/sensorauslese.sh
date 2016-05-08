#!/bin/bash
##
cd  /sys/bus/w1/devices/w1_bus_master1/



devices=$(ls)
#IFS=$

for D in *
do

if [[ $D ==  "10-"* ]]; then
	if [[ ! -d "/home/pi/ntz/$D" ]]; then
		mkdir /home/pi/ntz/$D
		mkdir /home/pi/ntz/$D/logs
		touch /home/pi/ntz/$D/name
	else
		output=$(cat $D/w1_slave | sed -n "s/.*t=\(.*\)/\1/p")
		timestamp=$(date +"%Y_%m_%d_%k_%M")

		echo $output > /home/pi/ntz/$D/logs/$timestamp		
	fi
fi

done
