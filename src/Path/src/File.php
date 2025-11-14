<?php

declare(strict_types=1);

namespace Phparm\Path;

use Phparm\Entity\Attribute;

class File extends Attribute
{
    public string $dirname;
    public string $basename;
    public string $filename;
    public string $extension;
}