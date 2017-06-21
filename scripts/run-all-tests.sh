#!/bin/bash

# Self Command to run:
# bash ./scripts/run-all-tests.sh

echo "Restarting Selenium2..."
sudo ./scripts/stop-selenium.sh
sudo ./scripts/start-selenium.sh &> /dev/null

# Clean Cache
echo "Cleaning cache..."
rm -rf ./var/cache/*
./bin/console cache:clear --env=test

# Clear database metadata cache
echo "Cleaning database metadata cache..."
./bin/console doctrine:cache:clear-metadata --env=test

# Drop Database Schema (get rid off all tables)
echo "Dropping schema..."
./bin/console doctrine:schema:drop --env=test --force

# Create Database Schema
echo "Creating schema..."
./bin/console doctrine:schema:create --env=test

echo "Preparing to run all suites..."
suites=('routing' 'contact_form' 'hooks' 'subscription' 'product' 'login')
for suite in "${suites[@]}"
do
    echo "RUNNING SUITE TEST ${suite}..."
    ./bin/behat --config=app/config/behat.yml --suite="${suite}"
done

echo "Stopping Selenium2..."
sudo ./scripts/stop-selenium.sh
