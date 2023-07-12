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

cd ${__PROJECT__}/var

URL="http://127.0.0.1:8000/downloads.zip"

test -f downloads.zip || wget -O downloads.zip ${URL}

cd ${__PROJECT__}/var

test -d downloads && rm -rf downloads
unzip -o downloads.zip


cd ${__PROJECT__}/
mkdir -p downloads

awk 'BEGIN { cmd="cp -ri var/downloads/* downloads"  ; print "n" |cmd; }'
