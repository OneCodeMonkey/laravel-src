#!/usr/bin/env bash

echo "[step: 1/3] format checking..."
vendor/squizlabs/php_codesniffer/bin/phpcs --standard=PSR2 -q src/ tests/
echo "[step: 2/3] static debugging..."
vendor/bin/phpstan analyse --level 1 src/ tests/
echo "[step: 3/3] running tests..."
vendor/bin/phpunit tests/
