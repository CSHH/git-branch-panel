<?php

namespace HeavenProject\GitBranchPanel;

use Nette;

/**
 * Compiler extension for git branch panel.
 */
class GitBranchPanelExtension extends Nette\DI\CompilerExtension
{
    public function afterCompile(Nette\PhpGenerator\ClassType $class)
    {
        $initialize = $class->getMethod('initialize');
        $builder = $this->getContainerBuilder();

        $statement = new Nette\DI\Statement('HeavenProject\GitBranchPanel\Panel', array($_SERVER['SCRIPT_FILENAME'], '.git'));

        $initialize->addBody($builder->formatPhp(
            '$this->getService(?)->addPanel(?);',
            Nette\DI\Compiler::filterArguments(array('tracy.bar', $statement))
        ));
    }
}
