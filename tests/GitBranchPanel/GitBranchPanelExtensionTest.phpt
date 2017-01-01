<?php

namespace HeavenProject\Tests\GitBranch;

use HeavenProject;
use Tester;
use Tester\Assert;
use Nette;
use Nette\Utils\FileSystem;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class GitBranchPanelExtensionTest extends Tester\TestCase
{
    public function testGeneratedContainer()
    {
        $tmpDir = __DIR__ . '/../tmp/' . getmypid();
        @mkdir($tmpDir, 0777);

        $config = new Nette\Configurator;

        $config->setTempDirectory($tmpDir);
        $config->addConfig(__DIR__ . '/../config/config.neon');

        $tracyBar = $config->createContainer()->getService('tracy.bar');
        $class    = 'HeavenProject\GitBranchPanel\Panel';
        Assert::same($class, get_class($tracyBar->getPanel($class)));
    }

    public function testGeneratedContainerWithCustomEntryPath()
    {
        $tmpDir = __DIR__ . '/../tmp/' . getmypid();
        @mkdir($tmpDir, 0777);

        $config = new Nette\Configurator;

        $config->setTempDirectory($tmpDir);
        $config->addConfig(__DIR__ . '/../config/config-custom-entry-path.neon');
        $config->addParameters(array('appDir' => __DIR__));

        $container = $config->createContainer();
        $appDir    = $container->getParameters()['appDir'];
        $gitDir    = __DIR__ . '/.git';
        FileSystem::createDir($gitDir);
        FileSystem::write($gitDir . '/HEAD', 'ref: refs/heads/custom-entry-path-branch');
        $tracyBar  = $container->getService('tracy.bar');
        $class     = 'HeavenProject\GitBranchPanel\Panel';
        Assert::same($class, get_class($tracyBar->getPanel($class)));
        $branch    = new HeavenProject\GitBranchPanel\GitBranch(__DIR__, $gitDir);
        Assert::same('custom-entry-path-branch', $branch->getBranchName());
        FileSystem::delete($gitDir);
    }
}

$testCase = new GitBranchPanelExtensionTest;
$testCase->run();
