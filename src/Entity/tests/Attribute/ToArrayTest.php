<?php

declare(strict_types=1);

namespace PhparmTest\Entity\Attribute;

use PhparmTest\Entity\Entity\Data;
use PhparmTest\Entity\Entity\Tiger;
use PhparmTest\Entity\Entity\Zoo;
use PHPUnit\Framework\TestCase;

class ToArrayTest extends TestCase
{
    public function testToArray(): void
    {
        $tiger1 = Data::manchurianTiger();
        $tiger1['name'] = '阳阳';
        $tiger2 = Data::southChinaTiger();
        $tiger2['name'] = '虎妞';
        $zoo = Zoo::make();
        $zoo->manchurianTiger = Tiger::make($tiger1);
        $zoo->southChinaTiger = Tiger::make($tiger2);
        $expect = [
            'manchurianTiger' => $tiger1,
            'southChinaTiger' => $tiger2,
            'javanTiger' => null,
        ];
        $actual = $zoo->toArray();
        foreach ($expect as $key => $value) {
            if (is_array($value)) {
                ksort($expect[$key]);
                ksort($actual[$key]);
            }
        }
        $this->assertSame($expect, $actual);
    }
}
