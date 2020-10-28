#!/bin/bash -u

error_log=../xampp-linux/lampp/logs/error_log
sudo truncate --size=0 $error_log

selenium-side-runner \
  -c "browserName=chrome goog:chromeOptions.args=[--headless,--nogpu]" \
  --debug \
  --output-directory=./results \
  --output-format=junit \
  smartybook.side

echo "PHP Error:"
grep "PHP Error:"   $error_log

echo "PHP Warning:"
grep "PHP Warning:" $error_log

echo "PHP Notice:"
grep "PHP Notice:"  $error_log

echo
wc   $error_log
head $error_log
