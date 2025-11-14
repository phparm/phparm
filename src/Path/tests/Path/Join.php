<?php

declare(strict_types=1);

namespace PhparmTest\Path\Path;

use Phparm\Path\Path;
use PHPUnit\Framework\TestCase;

class Join extends TestCase
{
    public function testFile(): void
    {
        $dir = __DIR__;
        $actual = Path::join($dir, 'ListAll.php');
        $expect = __DIR__ . DIRECTORY_SEPARATOR . 'ListAll.php';
        $this->assertEquals($expect, $actual);
    }

    public function testPath(): void
    {
        $dir = __DIR__;
        $actual = Path::join($dir, 'path-a/', 'path-b', 'path.c/');
        $expect = __DIR__ . DIRECTORY_SEPARATOR . 'path-a' . DIRECTORY_SEPARATOR . 'path-b' . DIRECTORY_SEPARATOR . 'path.c/';
        $this->assertSame($expect, $actual);
    }

    public function testWithSlashPath(): void
    {
        $dir = __DIR__;
        $actual = Path::join($dir, '/path-a');
        $expect = __DIR__ . DIRECTORY_SEPARATOR . 'path-a';
        $this->assertSame($expect, $actual);
    }

    public function testWithRelativePath(): void
    {
        $dir = __DIR__;
        $actual = Path::join($dir, './path-a');
        $expect = __DIR__ . DIRECTORY_SEPARATOR . 'path-a';
        $this->assertSame($expect, $actual);
    }

    public function testBothWithRelativePath(): void
    {
        $actual = Path::join('./dir\-a/', './path-a\/');
        $expect = DIRECTORY_SEPARATOR . 'dir\-a' . DIRECTORY_SEPARATOR . 'path-a/';
        $this->assertSame($expect, $actual);
    }
}