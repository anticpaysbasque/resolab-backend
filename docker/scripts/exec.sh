#!/bin/bash

ACTION=$1
APP_DIR=$PWD

## Docker vars
SERVICE_NAME=resolab_php
#STACK_NAME=ideage

# Hosts
HOST_HTTPS='https://localhost:8087'
HOST_HTTP='http://localhost:8089'

# Shortcuts symfony
CONSOLE='php bin/console'
UNIT='php bin/phpunit'
UNIT_OPTIONS=''

#Tests JS
YARN='yarn'
YARN_OPTIONS='run test'

# Docker Container ID
CONTAINER_ID=$(docker container ls | grep "$SERVICE_NAME" | grep -v "phpmyadmin" | sed -e 's/^\(.\{12\}\).*/\1/')

execute() {
    $ACTION
}

#############
# DOCKER
#############

build() {
  echo -e "\n\033[35m==========  Building Stack  ==========\n\033[37m"
  docker-compose build --no-cache
  echo -e "\n\033[32m ✔ Success! Your stack is builded 🎉 \n\033[37m"
}

deploy() {
    echo -e "\n\033[35m==========  Deploying Stack  ==========\n\033[37m"

    docker-compose up -d

    echo -e "\n\033[32m ✔ Success! Your stack is ready 🎉 \n\033[37m"
}

stop() {
    docker-compose stop
}

info() {
    echo -e "\n\033[35m==========  Infos  ==========\n\033[37m"

    echo -e "\033[33m Container ID: \033[34m$CONTAINER_ID\n\033[37m"

    echo -e "\033[33m Hosts:\033[37m"
    echo -e "\033[37m    - Ideage (HTTP):  \033[34m $HOST_HTTP \033[37m"
    echo -e "\033[37m    - Ideage (HTTPS):  \033[34m $HOST_HTTPS\033[37m"

    echo -e "\n\033[33m To go inside the container, run: \033[37m\033[45m make exec \033[37m\033[49m 🐳"
}

exec() {
    docker exec -it $CONTAINER_ID bash
}

permissions() {
    echo -e "\n\033[35m==========  Set Permissions  ==========\n\033[37m"
    sudo chmod 777 -fR var/cache || true
    sudo chmod 777 -R docker/mysql/
}

#############
# SYMFONY
#############

install() {
    cp config/packages/parameters.yaml.docker config/packages/parameters.yaml
    cmd 'composer install'
}

update() {
    cmd 'composer update --no-progress --dev --ansi -nv --prefer-dist --optimize-autoloader'
}

console() {
    cmd "$CONSOLE"
}

cache_clear() {
    cmd "$CONSOLE ca:cl"
}

database() {
  cmd "$CONSOLE doctrine:mongodb:schema:create"
}

#############
# Assets
#############

assets() {
    cmd 'yarn install && yarn run dev'
}

yarn() {
    cmd 'yarn run dev'
}

yarn_watch() {
    cmd 'yarn run watch'
}

cmd() {
    docker exec -it $CONTAINER_ID bash -c "$1"
}

#############
# Audit
#############

phpcpd() {
    cmd './vendor/sebastian/phpcpd/phpcpd src/'
}

phpcs_fixer() {
    cmd 'vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --using-cache=no --verbose --diff src/'
}

ci() {
    phpcs_fixer
    phpcpd
}

execute
