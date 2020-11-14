#!/bin/bash -uex

cd /opt/lampp/etc

cat php.ini \
  | sed -r "s/date.timezone\s*=.*/date.timezone = Asia\/Tokyo/" \
  | sed -r "s/;mbstring.internal_encoding\s*=\s*.*/mbstring.internal_encoding = utf-8/" \
  | sed -r "s/error_reporting\s*=\s*.*/error_reporting = E_ALL/" \
  | sed -r "s/;include_path\s*=.*/include_path =\./" \
  | sed -r "s/include_path\s*=.*/include_path =\./" \
  >php.ini.tmp

cp php.ini.tmp  php.ini


cd /opt/lampp/etc/extra

cat httpd-xampp.conf \
  | sed -r '/<Directory "\/opt\/lampp\/phpmyadmin">/,/<\/Directory>/s/Require local/Require all granted/' \
  >httpd-xampp.conf.tmp


cp httpd-xampp.conf.tmp  httpd-xampp.conf
