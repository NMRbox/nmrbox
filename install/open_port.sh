#!/bin/sh -e 
if [ $# -ne 2 ]; then
	echo "Usage $0: [port to open] [save file]"
	exit 1
fi
sudo iptables-save > $2
sudo iptables -I INPUT 3 -p tcp --dport $1 -j ACCEPT
echo "$1 opened, prior state saved to $2"
