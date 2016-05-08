#!/bin/bash
##
while true; do
cd  /sys/bus/w1/devices/w1_bus_master1/
echo "" > /home/pi/ntz/temps


devices=$(ls)
#IFS=$

for D in *
do

if [[ $D ==  "10-"* ]]; then
	if [[ ! -d "/home/pi/ntz" ]]; then
		echo "Ntz not found!"
	else
		output=$(cat $D/w1_slave | sed -n "s/.*t=\(.*\)/\1/p")
		
		echo $output >> /home/pi/ntz/temps		
	fi
fi

done
done
