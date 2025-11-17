<?php

declare(strict_types=1);

namespace Phparm\Path\Option;

use Phparm\Entity\Attribute;

/**
 * ========== property_hook_method ==========
 * @method int getPermissions()
 * @method bool getRecursive()
 * @method bool getSort()
 * @method int getSortFlags()
 * @method mixed|null getCallable()
 *
 * @method $this setPermissions(int $permissions)
 * @method $this setRecursive(bool $recursive)
 * @method $this setSort(bool $sort)
 * @method $this setSortFlags(int $sortFlags)
 * @method $this setCallable(mixed|null $callable)
 * ========== property_hook_method ==========
 */
class PathOption extends Attribute
{
    public int $permissions = 0777;
    public bool $recursive = true;
    public bool $sort = true;
    public int $sortFlags = SORT_REGULAR;
    public mixed $callable = null;
}