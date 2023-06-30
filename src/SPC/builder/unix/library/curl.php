<?php

declare(strict_types=1);

namespace SPC\builder\unix\library;

use SPC\store\FileSystem;

trait curl
{
    protected function build()
    {
        FileSystem::resetDir($this->source_dir . '/build');
        // 解决curl bug https://github.com/curl/curl/issues/6167
        shell()->cd($this->source_dir)
            ->exec('sed -i.save s@\${CMAKE_C_IMPLICIT_LINK_LIBRARIES}@@ CMakeLists.txt');

        $extra = ' -DCMAKE_INSTALL_PREFIX=' . BUILD_ROOT_PATH . ' ';
        $extra .= ' -DCMAKE_INSTALL_LIBDIR=' . BUILD_ROOT_PATH . '/lib/ ';
        $extra .= ' -DCMAKE_INSTALL_INCLUDEDIR=' . BUILD_ROOT_PATH . '/include ';
        $extra .= ' -DCMAKE_POLICY_DEFAULT_CMP0074=NEW ';
        $extra .= ' -DCMAKE_BUILD_TYPE=Release ';
        $extra .= ' -DBUILD_SHARED_LIBS=OFF ';

        $extra .= ' -DZLIB_ROOT=' . BUILD_ROOT_PATH . ' ';
        // lib:openssl
        if ($this->builder->getLib('openssl')) {
            $extra .= ' -DCURL_USE_OPENSSL=ON -DOpenSSL_ROOT=' . BUILD_ROOT_PATH . ' ';
        } else {
            $extra .= ' -DCURL_USE_OPENSSL=OFF -DCURL_ENABLE_SSL=OFF ';
        }
        // lib:brotli
        if ($this->builder->getLib('brotli')) {
            $extra .= ' -DCURL_BROTLI=ON -DBrotli_ROOT=' . BUILD_ROOT_PATH . ' ';
        } else {
            $extra .= ' -DCURL_BROTLI=OFF ';
        }
        // lib:libssh2
        if ($this->builder->getLib('libssh2')) {
            $extra .= ' -DLibSSH2_ROOT=' . BUILD_ROOT_PATH . ' ';
        } else {
            $extra .= ' -DCURL_USE_LIBSSH2=OFF ';
        }
        // lib:nghttp2
        if ($this->builder->getLib('nghttp2')) {
            $extra .= ' -DUSE_NGHTTP2=ON -DNGHTTP2_ROOT=' . BUILD_ROOT_PATH . ' ';
        } else {
            $extra .= ' -DUSE_NGHTTP2=OFF  ';
        }

        // TODO: ldap is not supported yet
        $extra .= ' -DCURL_DISABLE_LDAP=ON ';

        // lib:zstd
        if ($this->builder->getLib('zstd')) {
            $extra .= ' -DCURL_ZSTD=ON -DZstd_ROOT=' . BUILD_ROOT_PATH . ' ';
        } else {
            $extra .= ' -DCURL_ZSTD=OFF ';
        }

        // lib:idn2
        if ($this->builder->getLib('idn2')) {
            $extra .= ' -DUSE_LIBIDN2=ON -DLIBIDN2_ROOT=' . BUILD_ROOT_PATH . ' ';
        } else {
            $extra .= ' -DUSE_LIBIDN2=OFF ';
        }

        // lib:psl
        if ($this->builder->getLib('psl')) {
            $extra .= ' -DCURL_USE_LIBPSL=ON  -DLibPSL_ROOT=' . BUILD_ROOT_PATH . ' ';
        } else {
            $extra .= ' -DCURL_USE_LIBPSL=OFF ';
        }

        // compile！
        shell()->cd($this->source_dir . '/build')
            ->exec("{$this->builder->configure_env} cmake   .. {$extra}")
            ->exec("make -j{$this->builder->concurrency}")
            ->exec('make install');
    }
}
