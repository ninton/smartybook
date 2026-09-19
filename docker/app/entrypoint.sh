#!/usr/bin/env bash
set -e

# Entrypoint script for the Docker container
git config --global --add safe.directory '*'

exec "$@"
