<?php

declare(strict_types=1);

namespace Phparm\Entity;

use Phparm\Contract\Serialization\Arrayable;
use Phparm\Contract\Serialization\Jsonable;
use JsonSerializable;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * ========== property_hook_method ==========
 * @method string getValue()
 *
 * @method $this setValue(string $value)
 * ========== property_hook_method ==========
 */
class StringValue extends Attribute
{
    public string $value = '';

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @param null|Arrayable<TKey,TValue>|Jsonable|JsonSerializable|static<TKey,TValue>|string|array $attributes
     * @param Option|null $option
     * @return array<TKey,TValue>
     */
    protected function transform($attributes, ?Option $option = null): array
    {
        $data = $attributes;
        if (is_string($data)) {
            $data = [
                'value' => $attributes,
            ];
        }
        return parent::transform($data, $option);
    }
}