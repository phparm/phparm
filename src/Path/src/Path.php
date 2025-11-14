<?php

declare(strict_types=1);

namespace Phparm\Path;

use Phparm\Entity\StringValue;
use Phparm\Path\Option\PathOption;
use RuntimeException;

class Path extends StringValue
{
    /**
     * @return File[]
     */
    public function listAll(?PathOption $option = null): array
    {
        $result = [];
        if (!is_dir($this->value)) {
            throw new RuntimeException(sprintf('Not directory "%s"', $this->value));
        }
        $dirObject = opendir($this->value);
        while (($basename = readdir($dirObject)) !== false) {
            if ($basename !== '.' && $basename !== '..') {
                $absolutePath = $this->value . DIRECTORY_SEPARATOR . $basename;
                $callable = $option?->getCallable();
                $fileResult = File::make($absolutePath);
                if ($callable && is_callable($callable)) {
                    $callRes = call_user_func($callable, file: $fileResult);
                    if ($callRes) {
                        $fileResult = $callRes;
                    }
                }
                $result[$basename] = $fileResult;
            }
        }
        closedir($dirObject);
        if ($option?->sort ?? true) {
            ksort($result, $option?->sortFlags ?? SORT_REGULAR);
        }
        return array_values($result);
    }

    public function makeUsable(?PathOption $option = null): bool
    {
        if (!is_dir($this->value)) {
            if (!mkdir($this->value, $option?->getPermissions() ?? 0777, $option?->getRecursive() ?? true) && !is_dir($this->value)) {
                throw new RuntimeException(sprintf('Failed to create directory "%s"', $this->value));
            }
        }
        return true;
    }

    public static function join(...$paths): string
    {
        $lastPath = end($paths);
        $lastDirSeparator = str_ends_with($lastPath, DIRECTORY_SEPARATOR);
        $result = [];
        foreach ($paths as $path) {
            if (str_starts_with($path, './')) {
                $path = trim($path, '\\/.');
            } else {
                $path = trim($path, '\\/');
            }
            if (!$path) {
                continue;
            }
            $result[] = $path;
        }
        $return = DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $result);
        if ($lastDirSeparator) {
            $return .= DIRECTORY_SEPARATOR;
        }
        return $return;
    }

    public static function absolute(string $path, string $rootPath = ''): string
    {
        if (!str_starts_with($path, '/')) {
            if (str_starts_with($path, './')) {
                $path = ltrim($path, './');
            }
            return self::join(
                $rootPath,
                $path,
            );
        }
        return $path;
    }
}