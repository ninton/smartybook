#!/bin/bash -uex

#composer phpcs

#composer phpmd

sudo docker-compose down
sudo docker-compose build
sudo docker-compose up -d
sudo docker-compose ps
./bin/xampp_start.sh

./bin/unittest.sh


cd selenium
./main.sh
cd ..


./bin/xampp_stop.sh
sudo docker-compose down
sudo docker-compose ps
