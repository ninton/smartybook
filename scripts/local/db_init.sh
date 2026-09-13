#!/usr/bin/env bash
set -e
set -u
set -x

PATH=/opt/lampp/bin:$PATH

DB_HOST=localhost
DB_PORT=3306
DB_USER=root

sql=$(dirname "$0")/db_init.sql

mysql --default-character-set=utf8 --user=$DB_USER --port=$DB_PORT --host=$DB_HOST <"$sql"
