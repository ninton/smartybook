#!/bin/bash -uex

./bin/db_init.sh

cd selenium
./main.sh
cd ..
