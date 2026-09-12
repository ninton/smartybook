#!/bin/bash -eu

sudo docker compose exec app /opt/lampp/htdocs/smartybook/db_init.sh
