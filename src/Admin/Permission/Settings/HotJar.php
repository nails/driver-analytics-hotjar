<?php

namespace Nails\Analytics\Driver\HotJar\Admin\Permission\Settings;

use Nails\Admin\Interfaces\Permission;

class HotJar implements Permission
{
    public function label(): string
    {
        return 'Can manage HotJar settings';
    }

    public function group(): string
    {
        return 'Settings';
    }
}
