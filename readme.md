# Git Branch Panel

Displays current Git branch on Tracy debug panel.

> **NOTE:** This source code is based on another Nette component,
see [here](http://addons.nette.org/vojtech-vondra/gitbranch-debug-panel)
and [here](https://gist.github.com/vvondra/3645108).

## Installation

`composer require --dev heavenproject/git-branch-panel`

## Requirements

- [Nette Framework](https://github.com/nette/nette)

## Documentation

In order to use Git Branch Panel you must register it as extension in configuration file:

```neon
extensions:
    gitPanel: HeavenProject\GitBranchPanel\GitBranchPanelExtension
```

The extension will search through all the parent directories for the `.git` directory and stops in the project root.

You can set custom path to a directory, in which the `.git` directory resides, this way:

```
gitPanel:
    entryPath: %appDir%/my/custom/path
```

If `appDir` is `/app`, the resulting path including the `.git` directory will be `/app/my/custom/path/.git`.

## License

This source code is [free software](http://www.gnu.org/philosophy/free-sw.html)
licensed under MIT [license](license.md).
