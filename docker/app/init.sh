#!/bin/sh -ux

sed -ri --file=/root/php_ini.sed     /opt/lampp/etc/php.ini

echo $(ip route | awk 'NR==1 {print $3}') host.docker.internal >>/etc/hosts

/bin/sh

