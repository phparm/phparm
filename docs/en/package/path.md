# Path

## Installation

```bash
composer require phparm/path
```

## Path

The class `\Phparm\Path\Path` extends `\Phparm\Entity\StringValue`.

### Concepts

Given `/path-a/path-b/file.readme`:

- Root path: the `/path-a/` portion.
- Absolute path: the `/path-a/path-b/file.readme` portion.
- Relative path: examples like `./file.readme`, `./path-b/`, `./path-b/file.readme`.
- Directory name: the `/path-a/path-b` portion.
- Basename: the `file.readme` portion.
- Filename: the `file` portion.
- File extension: the `readme` portion.

### Methods

|       Method       |                      Description                       |
|:------------------:|:------------------------------------------------------:|
|    `listAll()`     | List all items under the path, excluding `.` and `..`. |
|   `makeUsable()`   |         Create the path if it does not exist.          |
|   `Path::join()`   |              Join multiple path segments.              |
| `Path::absolute()` |         Resolve the path to an absolute path.          |

### Usage

#### listAll

```php
<?php

use Phparm\Path\Path;
use Phparm\Path\Option\PathOption;
use Phparm\Path\File;

// example 1
$dir = __DIR__;
// The returned list is: \Phparm\Path\File[]
$list = Path::make($dir)->listAll();

// example 2
$fileCallback = static function (\Phparm\Path\File $file) use ($info, $packageDirPath) {
    // do something...
    // you can customize the data returned for each item
    return [];
};
$option = PathOption::make()
    ->setCallable($fileCallback);
$list = Path::make($packageDirPath)
    ->listAll($option);
```

#### makeUsable

```php
<?php

use Phparm\Path\Path;
use Phparm\Path\Option\PathOption;

// example 1
$path = Path::join(__DIR__, 'path-a', 'path-b');
Path::make($path)
    ->makeUsable();

// example 2
$option = PathOption::make()
    ->setPermissions(0755)
    ->setRecursive(false);
Path::make($path)
    ->makeUsable($option);
```

#### join

```php
<?php

use Phparm\Path\Path;

// example 1
$path = Path::join('/var/www', 'path-a/', 'path-b', 'path.c/');
echo $path; // /var/www/path-a/path-b/path.c/

// example 2
$path = Path::join('/var/www', 'path-a/', 'path-b');
echo $path; // /var/www/path-a/path-b
```

#### absolute

```php
<?php

use Phparm\Path\Path;

// example 1
$path = Path::absolute('./path-a/', '/var/www/');
echo $path; // /var/www/path-a/

// example 2
$path = Path::absolute('./path-b');
echo $path; // /path-b
```

## File

The class `\Phparm\Path\File` extends `\Phparm\Entity\Attribute`.

It is an object-oriented representation of [pathinfo](https://www.php.net/manual/en/function.pathinfo.php); its
properties correspond to the same fields.

### Methods

|    Method    |           Description            |
|:------------:|:--------------------------------:|
|  `isDir()`   | Whether the path is a directory. |
|  `exists()`  |     Whether the file exists.     |
| `absolute()` |    Return the absolute path.     |

### Usage

Directory structure:

```txt
├── folder1/
│   ├── file1.txt
│   └── file3.txt
└── folder2/
    └── file2.txt
```

Examples:

```php
<?php

use Phparm\Path\File;

// example 1
$file = File::make('/folder1');
$file->isDir(); // true

// example 2
$file = File::make('/folder1/file1.txt');
$file->isDir(); // false
$file->absolute(); // /folder1/file1.txt
```