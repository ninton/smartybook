#!/usr/bin/env bash
set -ux

cd lib/pear-pear.php.net || exit 1

find . -name "*.php" -print0 | xargs -0 -l1 grep --with-filename -e '=\s*&\s*new'

find . -name "*.php" -print0 | xargs -0 -l1 sed -ri 's/=\s*\&\s*new/= new/'

find . -name "*.php" -print0 | xargs -0 -l1 grep --with-filename -e '=\s*&\s*new'


sed -ri 's/function fetchData\(\$user, \$pass\)/function fetchData\(\$user, \$pass, \$isChallengeResponse = false\)/' Auth/Auth/Container/Array.php
