#!/bin/bash -eux

DB_HOST=127.0.0.1
DB_PORT=5403
DB_USER=
DB_PASS=

mysql --user=$DB_USER --password=$DB_PASS --port=$DB_PORT --host=$DB_HOST smartybook <$sql
