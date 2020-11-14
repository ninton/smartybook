#!/bin/bash -eux

sudo /bin/rm -rf lampp

# PHP 5.2.9
#url="https://versaweb.dl.sourceforge.net/project/xampp/XAMPP%20Linux/1.7.1/xampp-linux-1.7.1.tar.gz"
#wget --timestamping  --no-if-modified-since  $url
#tar xzf xampp-linux-1.7.1.tar.gz

# PHP 5.3.8
#url="https://versaweb.dl.sourceforge.net/project/xampp/XAMPP%20Linux/1.7.7/xampp-linux-1.7.7.tar.gz"
#wget --timestamping  --no-if-modified-since  $url
#tar xzf xampp-linux-1.7.7.tar.gz

# PHP 5.4.7
#url="https://versaweb.dl.sourceforge.net/project/xampp/XAMPP%20Linux/1.8.1/xampp-linux-1.8.1.tar.gz"
#wget --timestamping  --no-if-modified-since  $url
#tar xzf xampp-linux-1.8.1.tar.gz

# PHP 5.6.40
url="https://jaist.dl.sourceforge.net/project/xampp/XAMPP%20Linux/5.6.40/xampp-linux-x64-5.6.40-1-installer.run"
wget --timestamping  --no-if-modified-since  $url
chmod +x xampp-linux-x64-5.6.40-1-installer.run

# PHP 7.4.40
#url="https://jaist.dl.sourceforge.net/project/xampp/XAMPP%20Linux/7.4.11/xampp-linux-x64-7.4.11-0-installer.run"
#wget --timestamping  --no-if-modified-since  $url

./chmod.sh
./pear_download.sh
