<?php

declare(strict_types=1);

namespace SPC\builder\unix\library;

use SPC\store\FileSystem;

trait brotli
{
    protected function build(): void
    {
        FileSystem::resetDir($this->source_dir . '/build-dir');
        shell()->cd($this->source_dir . '/build-dir')
            ->exec(
                $this->builder->configure_env . ' cmake ' .
                "{$this->builder->makeCmakeArgs()} " .
                '-DBUILD_SHARED_LIBS=OFF ' .
                '..'
            )
            ->exec("cmake --build . -j {$this->builder->concurrency}")
            ->exec('make install');
        shell()->cd(BUILD_ROOT_PATH . '/lib')
            ->exec('cp -f  libbrotlicommon-static.a libbrotlicommon.a')
            ->exec('cp -f libbrotlidec-static.a libbrotlidec.a')
            ->exec('cp -f libbrotlienc-static.a libbrotlienc.a');
        foreach (FileSystem::scanDirFiles(BUILD_ROOT_PATH . '/lib/', false, true) as $filename) {
            if (str_starts_with($filename, 'libbrotli') && (str_contains($filename, '.so') || str_ends_with($filename, '.dylib'))) {
                unlink(BUILD_ROOT_PATH . '/lib/' . $filename);
            }
        }
    }
}
