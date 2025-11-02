<?php

declare(strict_types=1);

namespace Config\MonorepoBuilder;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Symplify\MonorepoBuilder\ValueObject\Option;
use MonorepoBuilderPrefix202507\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Throwable;

class TagVersionReleaseWorker implements ReleaseWorkerInterface
{
    private string $branchName;

    public function __construct(
        private ProcessRunner $processRunner,
        ParameterProvider $parameterProvider
    ) {
        $this->branchName = $parameterProvider->provideStringParameter(Option::DEFAULT_BRANCH_NAME);
    }

    /**
     * @return array<string,callable(): bool|string>
     */
    public function shouldConfirm(): array
    {
        return [
            'whenTrue' => fn(): bool => $this->getDefaultBranch() !== null && $this->getCurrentBranch() !== $this->getDefaultBranch(),
            'message'=> sprintf('Do you want to release it on the [ %s ] branch?', $this->getCurrentBranch())
        ];
    }

    public function work(Version $version): void
    {
        try {
            $gitAddCommitCommand = sprintf(
                'git add . && git commit -m "release" && git push origin "%s"',
                $this->branchName
            );

            $this->processRunner->run($gitAddCommitCommand);
        } catch (Throwable) {
            // nothing to commit
        }

        $this->processRunner->run('git tag ' . $version->getOriginalString());
    }

    public function getDescription(Version $version): string
    {
        return sprintf('Add local tag "%s"', $version->getOriginalString());
    }

    private function getCurrentBranch(): ?string
    {
        exec('git rev-parse --abbrev-ref HEAD',$outputs,$result_code);

        return $result_code === 0 ? $outputs[0] : null;
    }

    private function getDefaultBranch(): ?string
    {
        exec('git remote set-head origin -a');
        exec("git symbolic-ref --short refs/remotes/origin/HEAD | cut -d '/' -f 2",$outputs,$result_code);

        return $result_code === 0 ? $outputs[0] ?? null : null;
    }
}
