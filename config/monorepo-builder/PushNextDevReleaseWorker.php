<?php

declare(strict_types=1);

namespace Config\MonorepoBuilder;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Symplify\MonorepoBuilder\Utils\VersionUtils;
use MonorepoBuilderPrefix202507\Symplify\PackageBuilder\Parameter\ParameterProvider;

class PushNextDevReleaseWorker implements ReleaseWorkerInterface
{
    private string $branchName = 'main';

    public function __construct(
        private ProcessRunner $processRunner,
        private VersionUtils $versionUtils,
        ParameterProvider $parameterProvider
    ) {
    }

    public function work(Version $version): void
    {
        $gitAddCommitCommand = 'git add . && git commit --allow-empty -m "release"';

        $this->processRunner->run($gitAddCommitCommand);
    }

    public function getDescription(Version $version): string
    {
        $versionInString = $this->getVersionDev($version);

        return sprintf('Push "%s" open to remote repository', $versionInString);
    }

    private function getVersionDev(Version $version): string
    {
        return $this->versionUtils->getNextAliasFormat($version);
    }
}
