#!/bin/bash -uex

#mkdir -p pear/auth
#cd pear/auth
#wget --timestamping  --no-if-modified-since  http://download.pear.php.net/package/Auth-1.6.4.tgz
#tar xzf Auth-1.6.4.tgz
#cd ../..


#mkdir -p pear/net
#cd pear/net
#wget --timestamping  --no-if-modified-since  http://download.pear.php.net/package/Net_UserAgent_Mobile-1.0.0.tgz
#tar xzf Net_UserAgent_Mobile-1.0.0.tgz
#cd ../..

mkdir -p pear/pager
cd pear/pager
wget --timestamping  --no-if-modified-since  http://download.pear.php.net/package/Pager-2.5.1.tgz
tar xzf Pager-2.5.1.tgz
cd ../..

#mkdir -p pear/json
#cd pear/json
#wget --timestamping  --no-if-modified-since  http://download.pear.php.net/package/Services_JSON-1.0.3.tgz
#tar xzf Services_JSON-1.0.3.tgz
#cd ../..

mkdir -p pear/amazon
cd pear/amazon
wget --timestamping  --no-if-modified-since  http://download.pear.php.net/package/Services_Amazon-0.9.0.tgz
tar xzf Services_Amazon-0.9.0.tgz
cd ../..

mkdir -p pear/xml
cd pear/xml
wget --timestamping  --no-if-modified-since  http://download.pear.php.net/package/XML_Serializer-0.21.0.tgz
tar xzf XML_Serializer-0.21.0.tgz
cd ../..



dst_dir=lampp/lib/php/

#cp     pear/auth/Auth-1.6.4/Auth.php $dst_dir
#cp -r  pear/auth/Auth-1.6.4/Auth     $dst_dir
#chmod g+r,o+r $dst_dir/Auth/Container/*.php

#cp -r  pear/net/Net_UserAgent_Mobile-1.0.0/Net $dst_dir

cp     pear/pager/Pager-2.5.1/Pager.php $dst_dir
cp -r  pear/pager/Pager-2.5.1/Pager     $dst_dir

#cp     pear/json/Services_JSON-1.0.3/JSON.php ../smartybook/chapter5_4/


cp  -r  pear/amazon/Services_Amazon-0.9.0/Services $dst_dir
cp  -r  pear/xml/XML_Serializer-0.21.0/XML $dst_dir
