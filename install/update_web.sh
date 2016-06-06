#!/bin/sh

showhelp ( ){
	echo "Update website from svn"
	echo "Usage: $0 -d [install directory]" 
	exit 1
}

while getopts "d:h" opt; do
    case $opt in
	h)
	showhelp
	;;
	d)
	installdir=$OPTARG
	;;
    esac
done

if [ -z $installdir ]; then
	echo "installdir (-d) not set, exiting"
	exit 2
fi
if [ ! -d $installdir ]; then
	echo "$installdir is not existing directory, exiting"
	exit 4
fi
uid=$(id -u)
if [ $uid -ne 0 ]; then
	echo "Execute as root (i.e. sudo)"
	exit 1
fi
cd $installdir || { echo "cd to $installdir failed"; exit 3; }
svn update || { echo "svn updated failed"; exit 4; }
chown -R www-data:www-data .
