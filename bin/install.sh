#!/bin/bash -uex

composer install

npm install

chmod +x chmod.sh
./chmod.sh || true

cd xampp-linux
./install.sh
cd ..
