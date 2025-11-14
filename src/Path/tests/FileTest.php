<?php

declare(strict_types=1);

namespace PhparmTest\Path;

use Phparm\Path\File;
use Phparm\Path\Path;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testIsDir(): void
    {
        $file = File::make(__FILE__);
        $actual = $file->isDir();
        $this->assertFalse($actual);
    }

    public function testAbsolute(): void
    {
        $file = File::make(__FILE__);
        $actual = $file->absolute();
        $expect = Path::join(__DIR__, 'FileTest.php');
        $this->assertSame($expect, $actual);
    }

    public function testDir(): void
    {
        $file = File::make(Path::join(__DIR__, 'Path'));
        $this->assertSame('Path', $file->basename);
        $this->assertSame('Path', $file->filename);
    }
}