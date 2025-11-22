<?php

declare(strict_types=1);

namespace Phparm\Path;

use Phparm\Entity\Attribute;
use Phparm\Entity\Option;

/**
 * ========== property_hook_method ==========
 * @method string getDirname()
 * @method string getBasename()
 * @method string getFilename()
 * @method string getExtension()
 *
 * @method $this setDirname(string $dirname)
 * @method $this setBasename(string $basename)
 * @method $this setFilename(string $filename)
 * @method $this setExtension(string $extension)
 * ========== property_hook_method ==========
 */
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
        return is_dir($this->absolute());
    }

    public function exists(): bool
    {
        return file_exists($this->absolute());
    }

    public function absolute(): string
    {
        return $this->dirname . DIRECTORY_SEPARATOR . $this->basename;
    }
}