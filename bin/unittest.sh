#!/bin/bash -uex

./bin/db_init.sh

rm -f smartybook/tests/simpletest.xml

sudo docker exec centos6.smartybook.docker /opt/lampp/htdocs/smartybook/tests/test.sh

cat smartybook/tests/simpletest.xml

cp  smartybook/tests/simpletest.xml  results/
