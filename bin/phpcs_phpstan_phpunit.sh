#!/usr/bin/env bash

echo "updating autoloading..."
composer update
echo "[step: 1/2] format checking..."
vendor/squizlabs/php_codesniffer/bin/phpcs --standard=PSR2 -q src/ tests/
echo "[step: 1/2] running tests..."
vendor/bin/phpunit tests/
