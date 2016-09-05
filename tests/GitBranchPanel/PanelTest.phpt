<?php

namespace HeavenProject\Tests\GitBranch;

use Tester;
use Tester\Assert;
use HeavenProject\GitBranchPanel\Panel;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class PanelTest extends Tester\TestCase
{
    public function testGetTabAsExistingBranch()
    {
        $panel = new Panel($_SERVER['SCRIPT_FILENAME'], 'mocks/git-branch');
        Assert::same(Panel::IMAGE . 'testing-branch', $panel->getTab());
    }

    public function testGetTabAsHashInDetachedHead()
    {
        $panel = new Panel($_SERVER['SCRIPT_FILENAME'], 'mocks/git-hash');
        Assert::same(Panel::IMAGE . '0000000', $panel->getTab());
    }

    public function testGetTabAsNotVersioned()
    {
        $panel = new Panel($_SERVER['SCRIPT_FILENAME'], '');
        Assert::same(Panel::IMAGE . 'not versioned', $panel->getTab());
    }

    public function testGetPanel()
    {
        $panel = new Panel('', '');
        Assert::same('', $panel->getPanel());
    }
}

$testCase = new PanelTest;
$testCase->run();
