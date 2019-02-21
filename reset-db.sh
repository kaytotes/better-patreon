#!/usr/bin/env bash

echo "================================================================="
echo "Attempting To Build Fresh Database"
echo "================================================================="

./vessel artisan migrate:fresh
./vessel artisan db:seed
./vessel artisan passport:install --force
./vessel artisan passport:keys
./vessel exec redis redis-cli FLUSHALL