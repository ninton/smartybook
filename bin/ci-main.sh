#!/bin/bash -ue

./bin/install.sh

composer xampp-start

composer test || true

composer xampp-stop
