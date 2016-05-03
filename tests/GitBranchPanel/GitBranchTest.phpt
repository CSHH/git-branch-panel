<?php

namespace HeavenProject\Tests\GitBranch;

use Tester;
use Tester\Assert;
use Mockery as m;
use phpmock\mockery\PHPMockery;
use HeavenProject\GitBranchPanel\GitBranch;

require __DIR__ . '/../bootstrap.php';

class GitBranchTest extends Tester\TestCase
{
    protected function tearDown()
    {
        m::close();
    }

    public function testGetBranchName()
    {
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'dirname')->andReturn('');
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'realpath')->andReturn('');
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'is_dir')->andReturn(true, true);
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'is_readable')->andReturn(true);
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'file_get_contents')->andReturn('ref: refs/heads/testing-branch');
        $branch = new GitBranch('', '');
        Assert::same('testing-branch', $branch->getBranchName());
    }

    public function testGetBranchNameAsHashInDetachedHead()
    {
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'dirname')->andReturn('');
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'realpath')->andReturn('');
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'is_dir')->andReturn(true, true);
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'is_readable')->andReturn(true);
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'file_get_contents')->andReturn('0000000000000000000000000000000000000000');
        $branch = new GitBranch('', '');
        Assert::same('0000000', $branch->getBranchName());
    }

    public function testGetBranchNameAsNotVersioned()
    {
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'dirname')->andReturn('');
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'realpath')->andReturn('');
        PHPMockery::mock('HeavenProject\GitBranchPanel', 'is_dir')->andReturn(true, false);
        $branch = new GitBranch('', '');
        Assert::same('not versioned', $branch->getBranchName());
    }

    public function testGetBranchNameAsIntegrationForExistingBranch()
    {
        $branch = new GitBranch($_SERVER['SCRIPT_FILENAME'], 'mocks/git-branch');
        Assert::same('testing-branch', $branch->getBranchName());
    }

    public function testGetBranchNameAsIntegrationForDetachedHead()
    {
        $branch = new GitBranch($_SERVER['SCRIPT_FILENAME'], 'mocks/git-hash');
        Assert::same('0000000', $branch->getBranchName());
    }

    public function testGetBranchNameAsIntegrationForNotVersioned()
    {
        $branch = new GitBranch($_SERVER['SCRIPT_FILENAME'], 'not-existent-directory-mock');
        Assert::same('not versioned', $branch->getBranchName());
    }
}

$testCase = new GitBranchTest;
$testCase->run();
