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

    public function testEmptyPath(): void
    {
        $actual = Path::join('', '  ', '	', '/path-b', '	', '', 'cache.json', '', '	');
        $expect = '/path-b/cache.json';
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
        $expect = './dir/-a' . DIRECTORY_SEPARATOR . 'path-a/';
        $this->assertSame($expect, $actual);
    }

    public function testBothWithBackslashRelativePath(): void
    {
        $actual = Path::join('.\dir\-a/', '.\path-a\/');
        $expect = './dir/-a' . DIRECTORY_SEPARATOR . 'path-a/';
        $this->assertSame($expect, $actual);
    }

    public function testHiddenDirRelativePath(): void
    {
        $actual = Path::join('/.ssh/', './id_rsa.pub');
        $expect = '/.ssh' . DIRECTORY_SEPARATOR . 'id_rsa.pub';
        $this->assertSame($expect, $actual);
    }

    public function testFirstHiddenDirRelativePath(): void
    {
        $actual = Path::join('.ssh/', './id_rsa.pub');
        $expect = '.ssh' . DIRECTORY_SEPARATOR . 'id_rsa.pub';
        $this->assertSame($expect, $actual);
    }

    public function testFirstMoreSlashRelativePath(): void
    {
        $actual = Path::join('.//dir\-a/', './path-a\/');
        $expect = './/dir/-a' . DIRECTORY_SEPARATOR . 'path-a/';
        $this->assertSame($expect, $actual);
    }

    public function testBackslash(): void
    {
        $actual = Path::join('Author\Path', 'Func\A\B');
        $expect = 'Author/Path' . DIRECTORY_SEPARATOR . 'Func/A/B';
        $this->assertSame($expect, $actual);
    }

    public function testStartEndBackslash(): void
    {
        $actual = Path::join('\Author\Path', 'Func\\');
        $expect = '/Author/Path' . DIRECTORY_SEPARATOR . 'Func/';
        $this->assertSame($expect, $actual);
    }
}