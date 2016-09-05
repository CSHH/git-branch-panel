<?php

namespace HeavenProject\GitBranchPanel;

use Nette;

/**
 * Compiler extension for git branch panel.
 */
class GitBranchPanelExtension extends Nette\DI\CompilerExtension
{
    public function loadConfiguration()
    {
        $config = $this->getConfig();
        $config['entryPath'] = isset($config['entryPath']) ? $config['entryPath'] : $_SERVER['SCRIPT_FILENAME'];
        $this->setConfig($config);
    }

    public function afterCompile(Nette\PhpGenerator\ClassType $class)
    {
        $initialize = $class->getMethod('initialize');
        $builder = $this->getContainerBuilder();

        $config = $this->getConfig();
        $statement = new Nette\DI\Statement('HeavenProject\GitBranchPanel\Panel', array($config['entryPath'], '.git'));

        $initialize->addBody($builder->formatPhp(
            '$this->getService(?)->addPanel(?);',
            Nette\DI\Compiler::filterArguments(array('tracy.bar', $statement))
        ));
    }
}
