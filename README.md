# Dotkernel Light

Dotkernel Light is a PSR-15 compliant application (skeleton) using Mezzio microframework and Laminas components.
It's designed as a minimal project to generate a simple website, like a presentation site.

> Check out our [demo](https://light.dotkernel.net/).

## Documentation

Documentation is available at: https://docs.dotkernel.org/light-documentation/

## Badges

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/light)
![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/dotkernel/light/php)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/light)](https://github.com/dotkernel/light/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/light)](https://github.com/dotkernel/light/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/light)](https://github.com/dotkernel/light/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/light)](https://github.com/dotkernel/light/blob/1.0/LICENSE)

[![Continuous Integration](https://github.com/dotkernel/light/actions/workflows/continuous-integration.yml/badge.svg?branch=1.0)](https://github.com/dotkernel/light/actions/workflows/continuous-integration.yml)
[![codecov](https://codecov.io/gh/dotkernel/light/graph/badge.svg?token=UpVJ5ELvfZ)](https://codecov.io/gh/dotkernel/light)
[![Qodana](https://github.com/dotkernel/light/actions/workflows/qodana_code_quality.yml/badge.svg)](https://github.com/dotkernel/light/actions/workflows/qodana_code_quality.yml)
[![Build Assets](https://github.com/dotkernel/light/actions/workflows/build-assets.yml/badge.svg?branch=1.0)](https://github.com/dotkernel/light/actions/workflows/build-assets.yml)

[![PHPStan](https://github.com/dotkernel/light/actions/workflows/static-analysis.yml/badge.svg?branch=1.0)](https://github.com/dotkernel/light/actions/workflows/static-analysis.yml)
![PHPstan Level](https://img.shields.io/badge/PHPStan-level%208-brightgreen)

## Contents

- [Requirements](#requirements)
- [Composer](#composer)
- [Choosing an Installation Path](#choosing-an-installation-path)
- [Installing Dotkernel `Light`](#installing-dotkernel-light)
- [Development Mode](#development-mode)
- [Bundling Static Modules](#bundling-static-modules)
- [Running the Application](#running-the-application)
- [Testing and Code Quality](#testing-and-code-quality)
- [Going Live](#going-live)

## Requirements

- **PHP** 8.3, 8.4 or 8.5 (`~8.3.0 || ~8.4.0 || ~8.5.0`).
  All three versions are covered by CI.
- **Node.js** `^20.19.0 || >=22.12.0` — required by the Vite and Sass versions used to build the interface.

npm ships bundled with Node.js, so any supported Node.js release provides a compatible npm.

> The exact Node.js versions the interface is built against are defined by the matrix in [`.github/workflows/build-assets.yml`](.github/workflows/build-assets.yml), which is the authoritative list.

The following paths must be writable by the user the web server runs as:

- `data/cache/` — compiled Twig templates and the aggregated configuration cache
- `log/` — application error logs

## Composer

Installation instructions:

- [Composer Installation -  Linux/Unix/OSX](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- [Composer Installation - Windows](https://getcomposer.org/doc/00-intro.md#installation-windows)

> If you have never used composer before make sure you read the [`Composer Basic Usage`](https://getcomposer.org/doc/01-basic-usage.md) section in Composer's documentation.

## Choosing an Installation Path

Example:

- absolute path `/var/www/dk`
- or relative path `dk` (equivalent with `./dk`)

## Installing Dotkernel `Light`

After you choose the path for Dotkernel light (`dk` will be used for the remainder of this example), let's move onto installation.

Clone the repository into that path — git creates the directory for you:

```shell
git clone https://github.com/dotkernel/light.git dk
cd dk
```

This method ensures that the default branch is installed, even if it is not released.

The dependencies have to be installed separately by running this command:

```shell
composer install
```

During installation, the `laminas/laminas-component-installer` Composer plugin prompts for some configuration settings, for example the lines below:

```shell
Please select which config file you wish to inject 'Laminas\HttpHandlerRunner\ConfigProvider' into:
  [0] Do not inject
  [1] config/config.php
  Make your selection (default is 1):
```

Select `[0] Do not inject`.
Dotkernel registers the config providers it needs explicitly in `config/config.php`, so automatic injection is not required.

If you choose `[1] config/config.php`, the `ConfigProvider` will be appended to that file instead.

The next question is:

`Remember this option for other packages of the same type? (Y/n)`

You should enter `y` and press `Enter`, so you are not asked again for every remaining component.

> This choice is remembered for **all** subsequent components, not just this one.
> If you later install a package whose `ConfigProvider` does need to be registered, add it to `config/config.php` yourself.

Finally, make sure your local configuration file exists:

```shell
cp config/autoload/local.php.dist config/autoload/local.php
```

> A Composer hook normally creates this file for you, but it is registered on `post-update-cmd` only, so it does not run for installs performed from an existing `composer.lock`.
> The file is git-ignored and holds your local settings — `application.url` and the page routes are defined here and nowhere else.

## Development Mode

Run this command to enable dev mode by turning debug flag to `true` and turning configuration caching to `off`.
It will also make sure that any existing config cache is cleared.

```shell
composer development-enable
```

## Bundling Static Modules

> Prerequisite software: Node.js `^20.19.0 || >=22.12.0`

To install dependencies into the `node_modules` directory run this command.

```shell
npm install
```

If `npm install` fails, this could be caused by user permissions of npm.
We recommend installing npm through `Node Version Manager`.

> You can skip the next step until you make changes in the `src/App/assets` folder

The build command compiles the components from the `src/App/assets` folder into the `public` folder.

> This command overwrites existing files in the `public` folder.

```shell
npm run build
```

While actively working on the assets, this command rebuilds them on every change instead of requiring a manual rebuild:

```shell
npm run watch
```

## Running the Application

For a quick look, PHP's built-in server is enough:

```shell
composer serve
```

The application is then available at http://localhost:8080.

For anything beyond that, we recommend running your applications in WSL:

- Make sure you have [WSL](https://github.com/dotkernel/development/blob/main/wsl/README.md) installed on your system.
- Currently we provide a distro implementation for [AlmaLinux10](https://docs.dotkernel.org/development/v2/setup/installation/).
- Install the application in a virtualhost as recommended by the chosen distro.
  The virtualhost document root must point to the `public` directory — the entry point is `public/index.php` — and never to the project root.
- Set `$baseUrl` in **config/autoload/local.php** to the address of your virtualhost.
- Run the application by opening the virtualhost address in your browser.

You should see the `Dotkernel Light` welcome page.

**NOTE:**

- If you are getting exceptions or errors regarding some missing services, clear the configuration cache:

```shell
composer clear-config-cache
```

> If `config-cache.php` is present that config will be loaded regardless of the `ConfigAggregator::ENABLE_CACHE` in `config/autoload/mezzio.global.php`

## Testing and Code Quality

Run every check at once — coding standard, Twig coding standard, static analysis and unit tests:

```shell
composer check
```

The individual commands are also available:

| Command | Purpose |
| --- | --- |
| `composer cs-check` / `composer cs-fix` | PHP coding standard (Laminas Coding Standard) |
| `composer twig-cs-check` / `composer twig-cs-fix` | Twig template coding standard |
| `composer static-analysis` | PHPStan, level 8 |
| `composer test` | PHPUnit test suite |

## Going Live

Before deploying to production, rename the robots file and adjust it for your site:

```shell
mv public/robots.txt.dist public/robots.txt
```
