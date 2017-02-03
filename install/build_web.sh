#!/bin/sh 

showhelp ( ){
	echo "Install website from svn"
	echo "Usage: $0 -n [fully qualified hostname] -d [install directory] -a [account] -s [svn location] -o [operating system] -e [environment] -b [database]"
	echo "hostname defaults to current host"
	echo "account defaults to www-data"
	echo "svn location defaults to trunk"
	echo "operating system defaults to ubuntu-14.04"
	echo "environment defaults to prod"
	echo "database defaults to registry"
	exit 1
}

#set defaults
hostname=$(hostname -A|xargs)
account=www-data
loc=trunk
os=ubuntu-14.04
env=prod
db=registry
svn_auth='--username buildserver --password boxofrocks --no-auth-cache'
while getopts "n:d:a:s:o:e:hb:" opt; do
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
	e)
	env=$OPTARG
	;;
	b)
	db=$OPTARG
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

#show checkout command
SVN_ROOT=https://devel.nmrbox.org/svn/nmrbox/$loc/web 
echo "Extracting code from $SVN_ROOT"
svn $svn_auth export -q ${SVN_ROOT}/website $installdir 
svn $svn_auth export -q ${SVN_ROOT}/vendor-$os $installdir/vendor

(
cat <<EO_ENV
# deployed from $SVN_ROOT
APP_ENV=$env
APP_DEBUG=true
APP_KEY=PjRcCklAPB9gcicXagEmpaQdDwnd8Bw9
APP_URL=nmrbox-webdev.cam.uchc.edu

DB_HOST=data.nmrbox.org
DB_DATABASE=registry
DB_USERNAME=laravel
DB_PASSWORD=nmr-laravel!

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=nmrbox.org@gmail.com
MAIL_PASSWORD=Nmrbox2016
MAIL_ENCRYPTION=tls

LDAP_HOST=nmrbox-buildserver2.nmrbox.org
LDAP_PORT=5050
EO_ENV
) > $installdir/.env
mkdir $installdir/bootstrap/cache
chmod 777 $installdir/bootstrap/cache
storage=$installdir/storage
chmod 777 $storage
find $storage -type d -exec chmod 777 {} \;


sudo chown -R $account:$account $installdir 

cd $installdir || { echo "cd to $installdir failed"; exit 3; }
php artisan cache:clear
php artisan config:clear
php artisan route:cache
envpath=$(readlink -f $installdir/.env)

echo "Review/edit $envpath to change database, etc."
