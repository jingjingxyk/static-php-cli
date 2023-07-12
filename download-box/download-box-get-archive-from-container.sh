#!/bin/bash

set -exu
__DIR__=$(
  cd "$(dirname "$0")"
  pwd
)
__PROJECT__=$(
  cd ${__DIR__}/../
  pwd
)
cd ${__PROJECT__}

test -d ${__PROJECT__}/var || mkdir -p ${__PROJECT__}/var

TAG='download-box-nginx-alpine-1.0-20230712T065158Z'

IMAGE="docker.io/jingjingxyk/static-php-cli:${TAG}"

cd ${__PROJECT__}/var

container_id=$(docker create $IMAGE) # returns container ID
docker cp $container_id:/usr/share/nginx/html/downloads.zip downloads.zip
docker rm $container_id

cd ${__PROJECT__}/var

test -d downloads && rm -rf downloads
unzip -o downloads.zip


cd ${__PROJECT__}/
mkdir -p downloads

awk 'BEGIN { cmd="cp -ri var/downloads/* downloads"  ; print "n" |cmd; }'

