<?php

declare(strict_types=1);

namespace SPC\builder\macos\library;

class openssl extends MacOSLibraryBase
{
    use \SPC\builder\unix\library\openssl;

    public const NAME = 'openssl';

    public string $env = '';

    public string $static_flag = ' ';
}
