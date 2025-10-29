<?php

declare(strict_types=1);

namespace PhparmTest\Entity\Entity;

use Phparm\Entity\Attribute;

class Zoo extends Attribute
{
    public Tiger $manchurianTiger; // 东北虎
    public ?Tiger $southChinaTiger = null; // 华南虎
    public ?Tiger $javanTiger = null; // 爪哇虎
}