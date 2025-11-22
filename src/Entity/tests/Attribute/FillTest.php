<?php

declare(strict_types=1);

namespace PhparmTest\Entity\Attribute;

use PhparmTest\Entity\Entity\Data;
use PhparmTest\Entity\Entity\Tiger;
use PHPUnit\Framework\TestCase;

class FillTest extends TestCase
{
    public function testConstructPublicAttr(): void
    {
        $expect = Data::manchurianTiger();
        $tiger = Tiger::make($expect);
        $actual = $tiger->all();
        ksort($expect);
        ksort($actual);
        $this->assertSame($expect, $actual);
    }

    public function testConstructWithProtectedAttr(): void
    {
        $expect = Data::manchurianTiger();
        $tiger2 = Tiger::make(array_merge($expect, [
            'iucn' => 'LC',
        ]));
        $actual = $tiger2->all();
        ksort($expect);
        ksort($actual);
        $this->assertSame($expect, $actual);
    }

    public function testFillPublicAttr(): void
    {
        $expect = Data::manchurianTiger();
        $tiger = Tiger::make()
            ->fill($expect);
        $actual = $tiger->all();
        ksort($expect);
        ksort($actual);
        $this->assertSame($expect, $actual);
    }

    public function testFillWithProtectedAttr(): void
    {
        $expect = Data::manchurianTiger();
        $tiger2 = Tiger::make()
            ->fill(array_merge($expect, [
                'iucn' => 'DD',
            ]));
        $actual = $tiger2->all();
        ksort($expect);
        ksort($actual);
        $this->assertSame($expect, $actual);
    }

}
