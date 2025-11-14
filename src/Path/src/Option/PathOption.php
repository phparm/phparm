<?php

declare(strict_types=1);

namespace Phparm\Path\Option;

use Phparm\Entity\Attribute;

/**
 * @method int getPermissions()
 * @method self setPermissions(int $permissions)
 * @method bool getRecursive()
 * @method self setRecursive(bool $recursive)
 * @method bool getSort()
 * @method self setSort(bool $sort)
 * @method int getSortFlags()
 * @method self setSortFlags(int $sortFlags)
 * @method mixed getCallable()
 * @method self setCallable(mixed $callable)
 */
class PathOption extends Attribute
{
    public int $permissions = 0777;
    public bool $recursive = true;
    public bool $sort = true;
    public int $sortFlags = SORT_REGULAR;
    public mixed $callable = null;
}