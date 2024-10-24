#!/usr/bin/bash

while true; do
    curl -b XDEBUG_SESSION=XDEBUG_ECLIPSE localhost:8000/wp-json/dt-public/pg-api/v1/trigger?relay=1bbb6c
    sleep 5
done
