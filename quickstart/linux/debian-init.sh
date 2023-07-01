#!/bin/bash

set -exu
__DIR__=$(
  cd "$(dirname "$0")"
  pwd
)
cd ${__DIR__}

# use china mirror
# bash quickstart/linux/debian-init.sh --mirror china
mirror=''
while [ $# -gt 0 ]; do
  case "$1" in
  --mirror)
    mirror="$2"
    shift
    ;;
  --*)
    echo "Illegal option $1"
    ;;
  esac
  shift $(($# > 0 ? 1 : 0))
done

case "$mirror" in
china)
  VERSION_ID=$(cat /etc/os-release | grep '^VERSION_ID=' | awk -F '=' '{print $2}')
  case $VERSION_ID in
  11)
    test -f /etc/apt/sources.list.save || cp /etc/apt/sources.list /etc/apt/sources.list.save
    sed -i "s@deb.debian.org@mirrors.ustc.edu.cn@g" /etc/apt/sources.list &&
      sed -i "s@security.debian.org@mirrors.ustc.edu.cn@g" /etc/apt/sources.list
    ;;
  12)
    test -f /etc/apt//etc/apt/sources.list.d/debian.sources.save || cp /etc/apt/sources.list.d/debian.sources /etc/apt/sources.list.d/debian.sources.save
    sed -i 's/deb.debian.org/mirrors.ustc.edu.cn/g' /etc/apt/sources.list.d/debian.sources
    ;;
  esac

  ;;

esac

apt update -y
apt install -y git curl wget ca-certificates
apt install -y xz-utils autoconf automake lld libtool cmake bison re2c gettext coreutils lzip zip unzip
apt install -y pkg-config bzip2 flex p7zip
apt install -y musl-tools g++
apt install -y clang

apt install -y linux-headers-$(uname -r)
