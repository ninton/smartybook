#!/bin/bash -ux

cd smartybook/vendor/pear-pear.php.net

find . -name "*.php" | xargs -l1 grep --with-filename -e '=\s*&\s*new'

find . -name "*.php" | xargs -l1 sed -ri 's/=\s*\&\s*new/= new/'

find . -name "*.php" | xargs -l1 grep --with-filename -e '=\s*&\s*new'


sed -ri 's/function fetchData\(\$user, \$pass\)/function fetchData\(\$user, \$pass, \$isChallengeResponse = false\)/' Auth/Auth/Container/Array.php
