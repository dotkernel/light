# light

Minimal project to generate a simple website.

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/light)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/light/5.0.0)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/light)](https://github.com/dotkernel/light/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/light)](https://github.com/dotkernel/light/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/light)](https://github.com/dotkernel/light/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/light)](https://github.com/dotkernel/light/blob/5.0/LICENSE.md)

[![Continuous Integration](https://github.com/dotkernel/light/actions/workflows/continuous-integration.yml/badge.svg?branch=1.0)](https://github.com/dotkernel/light/actions/workflows/continuous-integration.yml)
[![codecov](https://codecov.io/gh/dotkernel/light/graph/badge.svg?token=BQS43UWAM4)](https://codecov.io/gh/dotkernel/light)
[![Qodana](https://github.com/dotkernel/light/actions/workflows/qodana_code_quality.yml/badge.svg)](https://github.com/dotkernel/light/actions/workflows/qodana_code_quality.yml)

[![SymfonyInsight](https://insight.symfony.com/projects/a28dac55-3366-4020-9a49-53f6fcbeda4e/big.svg)](https://insight.symfony.com/projects/a28dac55-3366-4020-9a49-53f6fcbeda4e)

## Installing Dotkernel `light`

- [Installing Dotkernel `light`](#installing-dotkernel-light)
    - [Composer](#composer)
    - [Choose a destination path for Dotkernel `light` installation](#choosing-an-installation-path-for-dotkernel-light)
    - [Installing Dotkernel light](#installing-dotkernel-light)
    - [Configuration - First Run](#configuration---first-run)
    - [Testing (Running)](#running-the-application)

## Tools

Dotkernel light interface has been tested with npm v10.0.4 and Node.js v20.11.0.

### Composer

Installation instructions:

- [Composer Installation -  Linux/Unix/OSX](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- [Composer Installation - Windows](https://getcomposer.org/doc/00-intro.md#installation-windows)

> If you have never used composer before make sure you read the [`Composer Basic Usage`](https://getcomposer.org/doc/01-basic-usage.md) section in Composer's documentation

## Choosing an installation path for Dotkernel `light`

Example:

- absolute path `/var/www/dk`
- or relative path `dk` (equivalent with `./dk`)

## Installing Dotkernel `light`

After you choose the path for Dotkernel light (`dk` will be used for the remainder of this example), let's move onto installation.

### Installing Dotkernel `light` using git clone

This method ensures that the default branch is installed, even if it is not released. Run the following command:

```shell
git clone https://github.com/dotkernel/light.git .
```

The dependencies have to be installed separately, by running this command:

```shell
composer install
```

The setup script prompts for some configuration settings, for example the lines below:

```shell
Please select which config file you wish to inject 'Laminas\HttpHandlerRunner\ConfigProvider' into:
  [0] Do not inject
  [1] config/config.php
  Make your selection (default is 1):
```

Simply select `[0] Do not inject`, because Dotkernel includes its own configProvider which already contains the prompted configurations.

If you choose `[1] config/config.php` Laminas's `ConfigProvider` will be injected.

The next question is:

`Remember this option for other packages of the same type? (Y/n)`

You should enter `y` and press `Enter`.

## Configuration - First Run

- duplicate `config/autoload/local.php.dist` as `config/autoload/local.php`

## Development mode

Run this command to enable dev mode by turning debug flag to `true` and turning configuration caching to `off`. It will also make sure that any existing config cache is cleared.

```shell
composer development-enable
```

- If not already done, remove the `.dist` extension from `config/autoload/development.local.php.dist`.

## NPM Commands

To install dependencies into the `node_modules` directory run this command.

```shell
npm install
```

- If `npm install` fails, this could be caused by user permissions of npm. Recommendation is to install npm through `Node Version Manager`.

The watch command compiles the components then watches the files and recompiles when one of them changes.

```shell
npm run watch
```  

After all updates are done, this command compiles the assets locally, minifies them and makes them ready for production.

```shell
npm run prod
```

## Running the application

We recommend running your applications in WSL:

- make sure you have [WSL](https://github.com/dotkernel/development/blob/main/wsl/README.md) installed on your system
- currently we provide a distro implementations for [AlmaLinux9](https://github.com/dotkernel/development/blob/main/wsl/os/almalinux9/README.md)
- install the application in a virtualhost as recommended by the chosen distro
- set `$baseUrl` in **config/autoload/local.php** to the address of the virtualhost
- run the application by opening the virtualhost address in your browser

You should see the `Dotkernel light` welcome page.

**NOTE:**

- If you are getting exceptions or errors regarding some missing services, try running the following command:

```shell
sudo php bin/clear-config-cache.php
```

> If `config-cache.php` is present that config will be loaded regardless of the `ConfigAggregator::ENABLE_CACHE` in `config/autoload/mezzio.global.php`
