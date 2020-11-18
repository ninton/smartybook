#!/bin/bash -uex

composer install

./bin/patch_pear.sh

npm install

chmod +x chmod.sh
./chmod.sh || true

#cd xampp-linux
#./download.sh
#cd ..
