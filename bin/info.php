<?php

declare(strict_types=1);

error_reporting(E_ALL);

$baseDir = dirname(__DIR__);

require "$baseDir/vendor/autoload.php";

$info = file_get_contents("$baseDir/docs/public/info.json");
$info = json_decode($info, true);

if (!$info || !is_array($info)) {
    throw new \RuntimeException('const file is invalid.');
}

function writeToComposer(string $composerFilePath, array $info): void
{
    $composer = file_get_contents($composerFilePath);
    $composer = json_decode($composer, true);
    if (!$composer || !is_array($composer)) {
        throw new \RuntimeException(sprintf('composer file "%s" is invalid.', $composerFilePath));
    }
    $composer['name'] = $info['nameWithAuthor'];
    if (isset($composer['authors'])) {
        $composer['authors'] = $info['authors'];
    }
    if (isset($composer['homepage'])) {
        $composer['homepage'] = $info['githubUrl'];
    }
    if (isset($composer['support']['docs'])) {
        $composer['support']['docs'] = $info['docUrl'];
    }
    if (isset($composer['support']['issues'])) {
        $composer['support']['issues'] = $info['issueUrl'];
    }

    $composerContent = json_encode(
        $composer,
        JSON_PRETTY_PRINT | // 人类可读格式
        JSON_UNESCAPED_UNICODE | // 不转义 Unicode 字符
        JSON_UNESCAPED_SLASHES    // 不转义斜杠
    );
    file_put_contents($composerFilePath, $composerContent);
}

$composerFilePath = "$baseDir/composer.json";
writeToComposer($composerFilePath, $info);

$packageDirPath = "$baseDir/src";
$dirObject = opendir($packageDirPath);
while (($fileFullName = readdir($dirObject)) !== false) {
    if ($fileFullName !== '.' && $fileFullName !== '..') {
        $packageInfo = array_replace_recursive($info, $info['packages'][strtolower($fileFullName)]);
        writeToComposer($packageDirPath . "/" . $fileFullName . "/composer.json", $packageInfo);
    }
}
closedir($dirObject);