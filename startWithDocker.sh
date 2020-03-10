#!/bin/sh

docker run -v "${PWD}:/app" -v "${HOME}/.composer":/root/.composer -p 8009:8009 -w /app -it driftphp/base composer require cboden/ratchet
echo open echo.html
docker run -v "${PWD}:/app" -v "${HOME}/.composer":/root/.composer -p 8009:8009 -w /app -it driftphp/base php ratchet_server.php
