#!/usr/bin/env bash
set -ux

cd lib/pear-pear.php.net || exit 1

find . -name "*.php" -print0 | xargs -0 -l1 grep --with-filename -e '=\s*&\s*new'

find . -name "*.php" -print0 | xargs -0 -l1 sed -ri 's/=\s*\&\s*new/= new/'

find . -name "*.php" -print0 | xargs -0 -l1 grep --with-filename -e '=\s*&\s*new'

# 次の行の `$` はシェル変数ではなく、PHPの変数。展開したくないでシングルクォートで囲んでいます
# `shellcheck` で SC2016 警告されてしまうので、無視します
# SC2016 (info): Expressions don't expand in single quotes, use double quotes for that.
# shellcheck disable=SC2016
sed -ri 's/function fetchData\(\$user, \$pass\)/function fetchData\(\$user, \$pass, \$isChallengeResponse = false\)/' Auth/Auth/Container/Array.php
