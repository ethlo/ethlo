#!/bin/bash
cd "$(dirname "$0")/www"
/usr/bin/php7.4 ../gen.php > index.html
