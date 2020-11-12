#!/bin/bash -eux

sudo /bin/rm -rf lampp

# PHP 5.2.9
#wget --timestamping  --no-if-modified-since  "https://versaweb.dl.sourceforge.net/project/xampp/XAMPP%20Linux/1.7.1/xampp-linux-1.7.1.tar.gz"
#tar xzf xampp-linux-1.7.1.tar.gz

# PHP 5.3.8
#wget --timestamping  --no-if-modified-since  "https://versaweb.dl.sourceforge.net/project/xampp/XAMPP%20Linux/1.7.7/xampp-linux-1.7.7.tar.gz"
#tar xzf xampp-linux-1.7.7.tar.gz

# PHP 5.4.7
wget --timestamping  --no-if-modified-since  "https://versaweb.dl.sourceforge.net/project/xampp/XAMPP%20Linux/1.8.1/xampp-linux-1.8.1.tar.gz"
tar xzf xampp-linux-1.8.1.tar.gz



./chmod.sh
./pear_download.sh
