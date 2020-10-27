chmod -R o+w lampp/logs
chmod -R o+w lampp/tmp
chmod -R o+w lampp/var
chmod -R g+w lampp/var

chmod o+r lampp/phpmyadmin/config.inc.php

cat lampp/etc/php.ini \
  | sed "s/magic_quotes_gpc = On/magic_quotes_gpc = Off/" \
  | sed "s/;mbstring.internal_encoding = EUC-JP/mbstring.internal_encoding = utf-8/" \
  | sed "s#;include_path = \".*\"#include_path = \".:/opt/lampp/lib/php\"#" \
  >lampp/etc/php.ini.tmp

cp lampp/etc/php.ini.tmp lampp/etc/php.ini


chmod -R o+rw lampp/var
chmod -R g+rw lampp/var
chmod 777 lampp/var/mysql
chmod 777 lampp/var/mysql/cdcol
chmod 777 lampp/var/mysql/mysql
chmod 777 lampp/var/mysql/phpmyadmin
chmod 777 lampp/var/mysql/test


touch lampp/logs/mysqld.log
chmod o+w lampp/logs/mysqld.log
chmod g+w lampp/logs/mysqld.log

echo "[mysqld_safe]" >>lampp/etc/my.cnf
echo "log-error=/opt/lampp/logs/mysqld.log" >>lampp/etc/my.cnf
