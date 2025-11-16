<?php

declare(strict_types=1);

namespace PhparmTest\Path\Path;

use Phparm\Path\Path;
use PHPUnit\Framework\TestCase;

class Absolute extends TestCase
{
    public function testWithRootPath(): void
    {
        $dir = dirname(__DIR__);
        $actual = Path::absolute('./Path/', $dir);
        $expect = $dir . '/Path/';
        $this->assertSame($expect, $actual);
    }

    public function testWithoutRootPath(): void
    {
        $actual = Path::absolute('./Path/');
        $expect = '/Path/';
        $this->assertSame($expect, $actual);
    }

    public function testWithBackslash(): void
    {
        $actual = Path::absolute('.\/Path/');
        $expect = '/Path/';
        $this->assertSame($expect, $actual);
    }
}