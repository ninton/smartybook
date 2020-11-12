#!/bin/bash -uex

./bin/db_init.sh

n=$(find smartybook -name "007.jpg" | wc --line)
if [ "$n" != "0" ]; then
  find smartybook -name "007.jpg" | xargs -l1 rm
fi

n=$(find smartybook -name "%%*.php" | wc --line)
if [ "$n" != "0" ]; then
  find smartybook -name "%%*.php" | xargs -l1 rm
fi


cd selenium
./main.sh
cd ..
