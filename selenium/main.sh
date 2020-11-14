#!/bin/bash -ux

error_log="../xampp-linux/lampp/logs/error_log"
#error_log="../xampp-linux/lampp/logs/php_error_log"

sudo truncate --size=0 $error_log

script_dir=$(pwd)
imgpath=$script_dir/fixtures/007.jpg

cat smartybook.side \
  | sed "s#/home/aoki/Pictures/smartybook/007.jpg#$imgpath#g" \
  >smartybook.side.tmp

npx selenium-side-runner \
  -c "browserName=chrome goog:chromeOptions.args=[--headless,--nogpu]" \
  --debug \
  --output-directory=../results \
  --output-format=junit \
  smartybook.side.tmp

grep "] PHP " $error_log


echo
wc   $error_log
head $error_log
