<?php

declare(strict_types=1);

namespace PhparmTest\Path\Path;

use Phparm\Path\Path;
use PHPUnit\Framework\TestCase;

class MakeUsable extends TestCase
{
    public function testPathNotExists(): void
    {
        $path = Path::join(dirname(__DIR__, 4), 'runtime', 'path-a', 'path-b');
        rmdir($path);
        $this->assertFalse(is_dir($path));
        Path::make($path)
            ->makeUsable();
        $this->assertTrue(is_dir($path));
    }
}