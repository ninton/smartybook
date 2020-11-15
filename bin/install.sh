#!/bin/bash -uex

composer install

./bin/pear_patch.sh

npm install

chmod +x chmod.sh
./chmod.sh || true

#cd xampp-linux
#./download.sh
#cd ..
