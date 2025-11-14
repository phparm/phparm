<?php

declare(strict_types=1);

namespace PhparmTest\Path\Path;

use Phparm\Path\File;
use Phparm\Path\Path;
use PHPUnit\Framework\TestCase;

class ListAll extends TestCase
{
    public function testRegular(): void
    {
        $dir = __DIR__;
        $actual = Path::make($dir)->listAll();
        $expect = [
            File::make(pathinfo(Path::join($dir, 'Absolute.php'))),
            File::make(pathinfo(Path::join($dir, 'Join.php'))),
            File::make(pathinfo(Path::join($dir, 'ListAll.php'))),
        ];
        $this->assertEquals($expect, $actual);
    }

    public function testDirNotExists(): void
    {
        $this->expectException(\RuntimeException::class);
        $dir = Path::join(__DIR__, 'sub-dir');
        Path::make($dir)->listAll();
    }

    public function testMixDir(): void
    {
        $dir = Path::join(dirname(__DIR__, 2), 'src');
        $actual = Path::make($dir)->listAll();
        $expect = [
            File::make(pathinfo(Path::join($dir, 'File.php'))),
            File::make(pathinfo(Path::join($dir, 'Option'))),
            File::make(pathinfo(Path::join($dir, 'Path.php'))),
        ];
        $this->assertEquals($expect, $actual);
    }
}