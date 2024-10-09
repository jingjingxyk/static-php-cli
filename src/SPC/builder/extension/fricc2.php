<?php

declare(strict_types=1);

namespace SPC\builder\extension;

use SPC\builder\Extension;
use SPC\util\CustomExt;

#[CustomExt('fricc2')]
class fricc2 extends Extension
{
    public function getUnixConfigureArg(): string
    {
        return '--enable-fricc2load=static';
    }
}
