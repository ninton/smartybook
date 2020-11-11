#!/bin/bash -eux

wget --timestamping  --no-if-modified-since  "https://versaweb.dl.sourceforge.net/project/xampp/XAMPP%20Linux/1.7.7/xampp-linux-1.7.7.tar.gz"
tar xzf xampp-linux-1.7.7.tar.gz

./chmod.sh
./pear_download.sh
