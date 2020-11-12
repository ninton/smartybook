#!/bin/bash -eu

fileList=/tmp/smartybook.phpcs.lst

find smartybook/ -name "*.php"  \
  | grep -v "/vendor/"          \
  | grep -v "/templates_c"      \
  | grep -v "autorun.php"       \
  >$fileList

# Generic.Files.LineLength
# PSR1.Files.SideEffects,

./smartybook/vendor/bin/phpcs \
  --standard=PSR1,PSR2,PSR12  \
  --file-list=$fileList       \
  --exclude=Generic.Files.LineLength,PSR1.Methods.CamelCapsMethodName,PSR1.Files.SideEffects,PSR1.Classes.ClassDeclaration
