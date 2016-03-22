#!/bin/sh

showhelp ( ){
	echo "Install website from svn"
	echo "Usage: $0 -n [fully qualified hostname] -d [install directory] -a [account] -s [svn location] -o [operating system]"
	echo "hostname defaults to current host"
	echo "account defaults to www-data"
	echo "svn location defaults to trunk"
	echo "operating system defaults to ubuntu-14.04"
	exit 1
}

#set defaults
hostname=$(hostname -A|xargs)
account=www-data
loc=trunk
os=ubuntu-14.04
while getopts "n:d:a:s:h:" opt; do
    case $opt in
	h)
	showhelp
	;;
	n)
	hostname=$OPTARG
	;;
	d)
	installdir=$OPTARG
	;;
	a)
	account=$OPTARG
	;;
	s)
	loc=$OPTARG
	;;
	o)
	os=$OPTARG
	;;
    esac
done

if [ -z $installdir ]; then
	echo "installdir (-d) not set, exiting"
	exit 2
fi
if [ -e $installdir ]; then
	echo "$installdir already exists, exiting"
	exit 4
fi
#test we can write parent directory
parent=$(dirname $installdir)
if [ ! -w $parent ]; then
	echo "$parent not writable by this script"
	exit 3
fi

svn co -q https://nmrbox-devel.cam.uchc.edu/repos/nmrbox/$loc/web/website $installdir 
svn co -q https://nmrbox-devel.cam.uchc.edu/repos/nmrbox/trunk/web/vendor-$os $installdir/vendor

(
cat <<EO_ENV
APP_ENV=prod
APP_DEBUG=true
APP_KEY=PjRcCklAPB9gcicXagEmpaQdDwnd8Bw9
APP_URL=$hostname

DB_HOST=nmrbox-buildserver.cam.uchc.edu
DB_DATABASE=registry
DB_USERNAME=laravel
DB_PASSWORD=nmr-laravel!

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
EO_ENV
) > $installdir/.env

sudo chown -R $account:$account $installdir 
