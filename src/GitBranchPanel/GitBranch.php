<?php

namespace HeavenProject\GitBranchPanel;

class GitBranch
{
    /** @var string */
    private $entryPath;

    /** @var string */
    private $targetDir;

    /**
     * @param string $entryPath
     * @param string $targetDir
     */
    public function __construct($entryPath, $targetDir)
    {
        $this->entryPath = $entryPath;
        $this->targetDir = $targetDir;
    }

    /**
     * @return string
     */
    public function getBranchName()
    {
        $dir  = $this->findGitDirectory();
        $head = $dir . '/' . $this->targetDir . '/HEAD';

        if (is_dir($dir) && is_readable($head)) {
            $branch = file_get_contents($head);
            if (strpos($branch, 'ref:') === 0) {
                $parts = explode('/', $branch);
                $res   = array_slice($parts, 2);

                return implode('/', $res);
            } else {
                return substr($branch, 0, 7);
            }
        }

        return 'not versioned';
    }

    /**
     * @return string
     */
    private function findGitDirectory()
    {
        $dir = realpath(dirname($this->entryPath));

        while ($dir !== false && !is_dir($dir . '/' . $this->targetDir)) {
            $currentDir = $dir;
            $dir        = realpath($dir . '/..');

            if ($this->inRoot($dir, $currentDir)) {
                break;
            }
        }

        return $dir;
    }

    /**
     * @param  string $checkedDir
     * @param  string $currentDir
     * @return bool
     */
    private function inRoot($checkedDir, $currentDir)
    {
        return $checkedDir === $currentDir;
    }
}
