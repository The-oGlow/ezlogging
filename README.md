# ezLogging

![Software License](https://img.shields.io/github/license/The-oGlow/ezlogging?logo=github "Software License")
![GitHub Release](https://img.shields.io/github/v/release/The-oGlow/ezlogging?logo=github&include_prereleases&display_name=tag "GitHub Release")
![Language Count](https://img.shields.io/github/languages/count/The-oGlow/ezlogging?logo=github "Language Count")
![Language Top](https://img.shields.io/github/languages/top/The-oGlow/ezlogging?logo=github "Language Top")

![PHP CS Fixer](https://img.shields.io/badge/php%20cs%20fixer-PSR%2012-orange?logo=php "PHP CS Fixer")
![PHPUnit](https://img.shields.io/badge/phpunit-UNIT%20Tests-orange?logo=php "PHPUnit")
![PHPStan](https://img.shields.io/badge/phpstan-Level%208%20Strict-orange?logo=php "PHPStan")
![PSalm](https://img.shields.io/badge/psalm-Level%202-orange?logo=php "Psalm") 
![Sonarcloud](https://img.shields.io/badge/sonarcloud-oGlow_way-orange?logo=sonar "Sonarcloud") \
[![Sonarcloud.io](https://sonarcloud.io/images/project_badges/sonarcloud-light.svg "Sonarcloud")](https://sonarcloud.io/summary/dashboard?id=The-oGlow_ezlogging)

## Description

Simplify the usage of
- Logging with [Monolog](https://seldaek.github.io/monolog/)
- Testing with [PHPUnit](https://phpunit.de/)
- [Reflection](https://www.php.net/manual/en/book.reflection.php) with PHP
- Developer shortkeys for composer

## Requirements

- [PHP](https://www.php.net)
- [Composer](https://getcomposer.org/) (optional)
- Commandline (opt.)
    - Linux / Unix Shell or
    - Windows Shell

## Configuration

### Unix / Linux

There is nothing to configure, you can use this library ootb.

### Windows

There is nothing to configure, you can use this library ootb.

## How to use it

### Monolog

- [ConsoleLogger](src/Monolog/ConsoleLogger.php) - Logging to console
- [FileLogger](src/Monolog/FileLogger.php) - Logging to a file
- [PlainLogger](src/Monolog/PlainLogger.php) - Logging "as it is" to console (raw)

### PHPUnit

- [EasyGoingTestCase](src/PHPUnit/Framework/EasyGoingTestCase.php) - All you need is already prepared, so concentrate on unit tests

### Reflection

- [UnavailableFieldsTrait](src/Tools/Reflection/UnavailableFieldsTrait.php) - Get value from unaccessable class fields (aka properties)
- [UnavailableMethodsTrait](src/Tools/Reflection/UnavailableMethodsTrait.php) - Call unaccessable class methods

## Quality Analysis

### Build 

| **Build**               | **Master** | **Develop** |
|:------------------------|:----------:|:-----------:|
| [Github.com](https://github.com/The-oGlow/ezLogging) | ![Commit Status Master](https://img.shields.io/github/check-runs/The-oGlow/ezlogging/master?logo=github "Commit Status Master") | ![Commit Status Develop](https://img.shields.io/github/check-runs/The-oGlow/ezlogging/develop?logo=github "Commit Status Develop") |                                                                                                                                                                                                                                                                                                                                                                                                                                                

### Quality Information

| **Quality Information** | **Master** | **Develop** |
|:------------------------|:----------:|:-----------:|
| [Sonarcloud.io](https://sonarcloud.io/project/dashboard?id=The-oGlow_ezlogging) | ![Quality Gate Master](https://img.shields.io/sonar/quality_gate/The-oGlow_ezlogging/master?logo=sonar&server=https%3A%2F%2Fsonarcloud.io "Status Quality Gate Master") | ![Quality Gate Develop](https://img.shields.io/sonar/quality_gate/The-oGlow_ezlogging/develop?logo=sonar&server=https%3A%2F%2Fsonarcloud.io "Status Quality Gate Develop") |

### Test Information

| **Test Information**    | **Master** | **Develop** |
|:------------------------|:----------:|:-----------:|
| [Sonarcloud.io](https://sonarcloud.io/project/dashboard?id=The-oGlow_ezlogging) |
| Test % | ![Sonarcloud](https://img.shields.io/sonar/test_success_density/The-oGlow_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&logo=sonar) | ![Sonarcloud](https://img.shields.io/sonar/test_success_density/The-oGlow_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&logo=sonar) |
| Tests Count | ![Sonarcloud](https://img.shields.io/sonar/tests/The-oGlow_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&logo=sonar) | ![Sonarcloud](https://img.shields.io/sonar/tests/The-oGlow_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&logo=sonar) |
| Coverage % | ![Sonarcloud](https://img.shields.io/sonar/coverage/The-oGlow_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&logo=sonar) | ![Sonarcloud](https://img.shields.io/sonar/coverage/The-oGlow_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&logo=sonar) |
| Violations | ![Sonarcloud](https://img.shields.io/sonar/violations/The-oGlow_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&logo=sonar) | ![Sonarcloud](https://img.shields.io/sonar/violations/The-oGlow_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&logo=sonar) |

## Development

Some infos, in case you want to fork and extend this library,

### Structure

Relevant files and folders

    <project-root>
    |--src
    |  |-- Monolog
    |  |-- PHPUnit
    |  |-- Tools
    |
    |--tests
    |  |-- Monolog
    |  |-- PHPUnit
    |  |-- Tools
    |
    |--vendor
    |  |- *
    |
    |-.php-cs-fixer.dist.php
    |-composer.json
    |-composer.lock
    |-LICENSE
    |-phpstan.neon.dist
    |-phpunit.xml.dist
    |-psalm.xml.dist
    |-README.md
    |-sonar-project.properties

### Build & Test

Start the whole build (run composer with c-fix, c-phpstan, c-psalm, c-test)

    composer c-all

### UNIT Tests

Starting the unit tests with PHPUnit

    composer c-test
    or
    composer c-test tests/Monolog/ConsoleLoggerTest.php

## Composer Commands

There are severall shortkeys, which are useful for your development.

| Command   | Description |
|-----------|-------------|
| c-all     | Run composer with c-fix, c-phpstan, c-psalm, c-test |
| c-da      | Alias for dump-autoload |
| c-dryfix  | Check code with PHP-CS-FIXER |
| c-fix     | Fix code with PHP-CS-FIXER |
| c-package | Create deployable package |
| c-phpstan | Check code with PHPStan |
| c-psalm   | Check code wtih Psalm |
| c-test    | Execute all or a single unit tests with PHPUnit |

See section 'scripts' & 'scripts-description'.
Copy them to you [composer.json](composer.json) if you like them! \

## Notice

Nothing to notice so far.

_(c) 2025 Oliver Glowa, coding.glowa.com_
