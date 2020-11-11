#!/bin/sh -eux

export PATH=/opt/lampp/bin:$PATH
php --version

cd /opt/lampp/htdocs/smartybook/tests

result_file=simpletest.xml
php autorun.php AllTests.php --junit >$result_file
chmod g+w,o+w $result_file
cat $result_file
