# 创建依赖库镜像 和 使用依赖库的镜像

## 创建依赖库容器镜像

```bash

# 准备依赖库源码包
bash download-box/download-box-init.sh

# 将源码包  打包到容器中
bash download-box/download-box-build.sh

```

## 部署依赖库容器镜像例子

```bash

IMAGE="docker.io/jingjingxyk/static-php-cli:download-box-nginx-alpine-1.0-20230712T065158Z"

mkdir -p var 
echo "${IMAGE}" > var/download-box.txt

bash sapi/download-box/download-box-server-run.sh

```

> 本地浏览器打开地址：   [`http://0.0.0.0:8000`](http://0.0.0.0:8000)  即可查看镜像服务器

## 依赖库镜像的分发方式

1. 通过容器仓库分发
1. 通过 web 分发

## 依赖库镜像的使用

### 方式一（来自容器分发）：

> 原理：  `docker cp [container_id]:dir dest_dir`

```bash

bash sapi/download-box/download-box-get-archive-from-container.sh

```

### 方式二（来自web服务器）：

> 原理： 下载：`http://127.0.0.1:8000/downloads.zip`
> 自动解压，并自动拷贝到 `downloads/` 目录

```bash

bash  sapi/download-box/download-box-get-archive-from-server.sh

```

