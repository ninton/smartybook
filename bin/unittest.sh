#!/bin/bash -uex

./bin/db_init.sh

rm -f smartybook/tests/simpletest.xml

sudo docker compose exec app /opt/lampp/htdocs/smartybook/tests/test.sh

cat smartybook/tests/simpletest.xml

cp  smartybook/tests/simpletest.xml  results/
