#!/bin/bash -eu

fileList=smartybook.phpcs.lst.tmp

find smartybook/ -name "*.php"  \
  | grep -v "/vendor/"          \
  | grep -v "/templates_c"      \
  | grep -v "autorun.php"       \
  | sort \
  >$fileList

# Generic.Files.LineLength
# PSR1.Files.SideEffects
# PSR1.Classes.ClassDeclaration

./smartybook/vendor/bin/phpcs \
  --standard=PSR1,PSR2,PSR12  \
  --file-list=$fileList       \
  --exclude=PSR1.Methods.CamelCapsMethodName

rm $fileList
