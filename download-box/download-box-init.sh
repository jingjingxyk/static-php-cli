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

cd ${__PROJECT__}/

while [ $# -gt 0 ]; do
  case "$1" in
  --proxy)
    export HTTP_PROXY="$2"
    export HTTPS_PROXY="$2"
    export NO_PROXY="127.0.0.1,localhost,ssl.google-analytics.com,127.0.0.0/8,10.0.0.0/8,100.64.0.0/10,172.16.0.0/12,192.168.0.0/16,198.18.0.0/15,169.254.0.0/16"
    export NO_PROXY="${NO_PROXY},.aliyuncs.com,.taobao.org,.aliyun.com"
    export NO_PROXY="${NO_PROXY},.tsinghua.edu.cn,.ustc.edu.cn,.npmmirror.com"
    shift
    ;;
  --*)
    echo "Illegal option $1"
    ;;
  esac
  shift $(($# > 0 ? 1 : 0))
done

cd ${__PROJECT__}

export COMPOSER_ALLOW_SUPERUSER=1

composer update  --optimize-autoloader

chmod +x bin/spc

./bin/spc fetch --all --debug

