<?php

declare(strict_types=1);

namespace SPC\builder\unix\library;

trait ncurses
{
    protected function build()
    {
        shell()->cd($this->source_dir)
            ->exec(
                "{$this->builder->configure_env} ./configure " .
                '--enable-static ' .
                '--disable-shared ' .
                // '--enable-overwrite ' .
                // '--with-curses-h ' .
                '--enable-pc-files ' .
                '--enable-echo ' .
                '--enable-widec ' .
                '--with-normal ' .
                '--with-ticlib ' .
                '--without-tests ' .
                '--without-dlsym ' .
                '--without-debug ' .
                '-enable-symlinks' .
                '--bindir=' . BUILD_ROOT_PATH . '/bin ' .
                '--includedir=' . BUILD_ROOT_PATH . '/include ' .
                '--libdir=' . BUILD_ROOT_PATH . '/lib ' .
                '--prefix=' . BUILD_ROOT_PATH
            )
            ->exec('make clean')
            ->exec("make -j{$this->builder->concurrency}")
            ->exec('make install');
        shell()->exec('cp -f ' . BUILD_ROOT_PATH . '/lib/libformw.a ' . BUILD_ROOT_PATH . '/lib/libform.a');
        shell()->exec('cp -f ' . BUILD_ROOT_PATH . '/lib/libmenuw.a ' . BUILD_ROOT_PATH . '/lib/libmenu.a');
        shell()->exec('cp -f ' . BUILD_ROOT_PATH . '/lib/libncurses++w.a ' . BUILD_ROOT_PATH . '/lib/libncurses++.a');
        shell()->exec('cp -f ' . BUILD_ROOT_PATH . '/lib/libncursesw.a ' . BUILD_ROOT_PATH . '/lib/libncurses.a');
        shell()->exec('cp -f ' . BUILD_ROOT_PATH . '/lib/libpanelw.a ' . BUILD_ROOT_PATH . '/lib/libpanel.a');
        shell()->exec('cp -f ' . BUILD_ROOT_PATH . '/lib/libticw.a ' . BUILD_ROOT_PATH . '/lib/libtic.a');

        shell()->exec(
            'cp -f ' . BUILD_ROOT_PATH . '/lib/pkgconfig/formw.pc ' . BUILD_ROOT_PATH . '/lib/pkgconfig/form.pc'
        );
        shell()->exec(
            'cp -f ' . BUILD_ROOT_PATH . '/lib/pkgconfig/menuw.pc ' . BUILD_ROOT_PATH . '/lib/pkgconfig/menu.pc'
        );
        shell()->exec(
            'cp -f ' . BUILD_ROOT_PATH . '/lib/pkgconfig/ncurses++w.pc ' . BUILD_ROOT_PATH . '/lib/pkgconfig/ncurses++.pc'
        );
        shell()->exec(
            'cp -f ' . BUILD_ROOT_PATH . '/lib/pkgconfig/ncursesw.pc ' . BUILD_ROOT_PATH . '/lib/pkgconfig/ncurses.pc'
        );
        shell()->exec(
            'cp -f ' . BUILD_ROOT_PATH . '/lib/pkgconfig/panelw.pc ' . BUILD_ROOT_PATH . '/lib/pkgconfig/panel.pc'
        );
        shell()->exec(
            'cp -f ' . BUILD_ROOT_PATH . '/lib/pkgconfig/ticw.pc ' . BUILD_ROOT_PATH . '/lib/pkgconfig/tic.pc'
        );
    }
}
