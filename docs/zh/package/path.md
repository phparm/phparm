# Path

## 安装

```bash
composer require phparm/path
```

## Path

`\Phparm\Path\Path` 继承于 `\Phparm\Entity\StringValue`

### 概念

`/path-a/path-b/file.readme`

- 根路径：指 `/path-a/` 部分。
- 绝对路径：指 `/path-a/path-b/file.readme` 部分。
- 相对路径：指 `./file.readme`、`./path-b/`、`./path-b/file.readme`。
- 目录名称：指 `/path-a/path-b` 部分。
- 基本名称：指 `file.readme` 部分。
- 文件名称：指 `file` 部分。
- 文件拓展：指 `readme` 部分。

### 方法

| 方法                 | 说明                    |
|:-------------------|:----------------------|
| `listAll()`        | 列出路径下的所有项，去掉`.`和`..`。 |
| `makeUsable()`     | 如果路径不存在将创建。           |
| `Path::join()`     | 加入多个路径。               |
| `Path::absolute()` | 将路径处理成绝对路径。           |

### 使用

#### listAll
```php
<?php

use Phparm\Path\Path;
use Phparm\Path\Option\PathOption;
use Phparm\Path\File;

// example 1
$dir = __DIR__;
// list的结果集是: \Phparm\Path\File[]
$list = Path::make($dir)->listAll();

// example 2
$fileCallback = static function (\Phparm\Path\File $file) use ($info, $packageDirPath) {
    // 做某事...
    // 可以自定义返回item的数据
    return [];
};
$option = PathOption::make()
    ->setCallable($fileCallback);
$list = Path::make($packageDirPath)
    ->listAll($option);
```

## File

`\Phparm\Path\File` 继承于 `\Phparm\Entity\Attribute`

[pathinfo](https://www.php.net/manual/zh/function.pathinfo.php)的对象版本，属性值与其一致。
