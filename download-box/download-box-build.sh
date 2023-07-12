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

cp -f ${__DIR__}/Dockerfile-dowload-box ${__PROJECT__}/var
cp -f ${__DIR__}/default.conf ${__PROJECT__}/var

cd ${__PROJECT__}

test -f downloads.zip || zip -r downloads.zip ./downloads
cp -f downloads.zip ${__PROJECT__}/var

cd ${__PROJECT__}/var

TIME=$(date -u '+%Y%m%dT%H%M%SZ')
VERSION="1.0"
TAG="download-box-nginx-alpine-${VERSION}-${TIME}"
IMAGE="docker.io/jingjingxyk/static-php-cli:${TAG}"

docker build -t ${IMAGE} -f ./Dockerfile-dowload-box . --progress=plain
echo ${IMAGE} >download-box.txt

docker push ${IMAGE}
