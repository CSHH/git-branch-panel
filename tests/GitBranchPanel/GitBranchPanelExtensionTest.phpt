<?php

namespace HeavenProject\Tests\GitBranch;

use Tester;
use Tester\Assert;
use Nette;

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

        $tracyBar = $config->createContainer()->getService('tracy.bar');
        $class    = 'HeavenProject\GitBranchPanel\Panel';
        Assert::same($class, get_class($tracyBar->getPanel($class)));
    }
}

$testCase = new GitBranchPanelExtensionTest;
$testCase->run();
