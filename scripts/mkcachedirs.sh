#!/bin/bash

sudo chown -R marc.marc ~/php_apps/rrgdev
chmod -R 775 ~/php_apps/rrgdev

mkdir -p ~/php_apps/rrgdev/app/tmp/cache
mkdir -p ~/php_apps/rrgdev/app/tmp/cache/persistent
mkdir -p ~/php_apps/rrgdev/app/tmp/cache/models
chmod -R 777 ~/php_apps/rrgdev/app/tmp