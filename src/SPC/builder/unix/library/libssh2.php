<?php

declare(strict_types=1);

namespace SPC\builder\unix\library;

use SPC\store\FileSystem;

trait libssh2
{
    protected function build()
    {
        $enable_zlib = $this->builder->getLib('zlib') !== null ? 'ON' : 'OFF';

        FileSystem::resetDir($this->source_dir . '/build');
        shell()->cd($this->source_dir . '/build')
            ->exec(
                "{$this->builder->configure_env} " . ' cmake ' .
                '-DCMAKE_INSTALL_PREFIX=' . BUILD_ROOT_PATH . ' ' .
                '-DCMAKE_INSTALL_LIBDIR=' . BUILD_ROOT_PATH . '/lib/ ' .
                '-DCMAKE_INSTALL_INCLUDEDIR=' . BUILD_ROOT_PATH . '/include ' .
                '-DCMAKE_BUILD_TYPE=Release ' .
                '-DBUILD_SHARED_LIBS=OFF ' .
                '-DBUILD_EXAMPLES=OFF ' .
                '-DBUILD_TESTING=OFF ' .
                "-DENABLE_ZLIB_COMPRESSION={$enable_zlib} " .
                '-DZLIB_ROOT=' . BUILD_ROOT_PATH . ' ' .
                '..'
            )
            ->exec("cmake --build . -j {$this->builder->concurrency} --target libssh2")
            ->exec('make install ');
    }
}
