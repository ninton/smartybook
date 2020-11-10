#!/bin/bash -u

#error_log="../xampp-linux/lampp/logs/error_log"
error_log="../xampp-linux/lampp/logs/php_error_log"

sudo truncate --size=0 $error_log

npx selenium-side-runner \
  -c "browserName=chrome goog:chromeOptions.args=[--headless,--nogpu]" \
  --debug \
  --output-directory=../results \
  --output-format=junit \
  smartybook.side

grep "] PHP " $error_log


echo
wc   $error_log
head $error_log
