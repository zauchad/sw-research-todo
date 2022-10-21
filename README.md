## TODO List App

### Tech stack

- ✅ **PHP 8.1**
- ✅ **PHPUnit**
- ✅ **ReactJS 18+**
- ✅ **Symfony 6**
- ✅ **Boostrap 5.2**

### Static code analysis&fixers tools

- ✅ **PHP Coding Standards Fixer**
- ✅ **PHPStan**
- ✅ **Psalm**
- ✅ **ESLint**
- ✅ **Prettier**

### Requirements

- ✅ **Symfony CLI** (link to install: https://symfony.com/download#step-1-install-symfony-cli)
- ✅ **PHP 8.1**
- ✅ **SQLite** (link to install: https://www.sqlite.org/download.html)
- ✅ **Composer** (link to install: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- ✅ **yarn/npm**

## Installation

```sh
composer project:reset
composer build:prod:ui
```

## Run server

```sh
symfony serve
```

Then open address: https://127.0.0.1:8000

## Run tests

```sh
composer tests
```

## Run code quality checks

```sh
composer tests:php:cs
composer yarn:eslint
composer yarn:prettier
```

## Run code quality fixes

```sh
composer php:cs
composer php:quality
yarn eslint
yarn prettier
```

## POC

https://user-images.githubusercontent.com/36495919/196953827-29fd5a40-1b23-4347-8615-afb516da8fdb.mov
