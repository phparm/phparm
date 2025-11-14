<?php

declare(strict_types=1);

namespace Phparm\Path;

use Phparm\Entity\Attribute;
use Phparm\Entity\Option;

class File extends Attribute
{
    public string $dirname;
    public string $basename;
    public string $filename;
    public string $extension;

    protected function transform($attributes, ?Option $option = null): array
    {
        $data = $attributes;
        if (is_string($data)) {
            $data = pathinfo($data, PATHINFO_ALL);
        }
        return parent::transform($data, $option);
    }

    public function isDir(): bool
    {
        return is_dir(Path::join($this->dirname, $this->basename));
    }

    public function absolute(): string
    {
        return $this->dirname . DIRECTORY_SEPARATOR . $this->basename;
    }
}