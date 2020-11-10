#!/bin/bash -eux

PATH=/opt/lampp/bin:$PATH

DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASS=
sql=$(dirname $0)/db_init.sql

mysql --user=$DB_USER --port=$DB_PORT --host=$DB_HOST <$sql
