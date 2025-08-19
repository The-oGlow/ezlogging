# Yet Another Confluence REST API

![GitHub Release](https://img.shields.io/github/v/release/The-oGlow/ezlogging?logo=github&style=plastic&include_prereleases&sort=semver&display_name=tag "GitHub Release")
![Software License](https://img.shields.io/github/license/The-oGlow/ezlogging?logo=github&style=plastic "Software License")
![Language Count](https://img.shields.io/github/languages/count/The-oGlow/ezlogging?logo=github&style=plastic "Language Count")
![Language Top](https://img.shields.io/github/languages/top/The-oGlow/ezlogging?logo=github&style=plastic "Language Top")

![PHP CS Fixer](https://img.shields.io/badge/PHP%20CS%20Fixer-PSR%2012-orange?logo=phpunit&style=plastic "PHP CS Fixer")
![PHPUnit](https://img.shields.io/badge/PHPUnit-Tests-orange?logo=phpunit&style=plastic "PHPUnit")
![Sonarcloud](https://img.shields.io/badge/Sonarcloud-oGlow_way-orange?logo=phpunit&style=plastic "Sonarcloud")
![PHPStan](https://img.shields.io/badge/PHPStan-Level%208-orange?logo=phpunit&style=plastic "PHPStan")
![PSalm](https://img.shields.io/badge/PSalm-Level%204-orange?logo=phpunit&style=plastic "Psalm")

(c) 2025 Oliver Glowa, coding.glowa.com

# Description

Simplify the usage of
- logging with [Monolog](https://seldaek.github.io/monolog/)
- testing with [PHPUnit](https://phpunit.de/)
- [Reflection](https://www.php.net/manual/en/book.reflection.php) with PHP

# Requirements

- [PHP](https://www.php.net)
- [Composer](https://getcomposer.org/) (optional)
- Commandline (opt.)
    - Linux / Unix Shell or
    - Windows Shell

# Configuration

## Unix / Linux

- There is nothing to configure, you can use this library ootb

## Windows

- There is nothing to configure, you can use this library ootb

# How to use it

## Monolog

- [ConsoleLogger](src/Monolog/ConsoleLogger.php) - Logging to console
- [FileLogger](src/Monolog/FileLogger.php) - Logging to a file
- [PlainLogger](src/Monolog/PlainLogger.php) - Logging "as it is" to console (raw)

## PHPUnit

- [EasyGoingTestCase](src/PHPUnit/Framework/EasyGoingTestCase.php) - All you need is already prepared, so concentrate on unit tests

## Reflection

- [UnavailableFieldsTrait](src/Tools/Reflection/UnavailableFieldsTrait.php) - Get value from unaccessable class fields (aka properties)
- [UnavailableMethodsTrait](src/Tools/Reflection/UnavailableMethodsTrait.php) - Call unaccessable class methods

# Development

Some infos, in case you want to fork and extend this library,

## Structure

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

## Build

Start the whole build (run composer with c-fix, c-phpstan, c-psalm, c-test)

    composer c-all

## UNIT Tests

Starting the unit tests (PHP Unit)

    composer c-test
    or
    composer c-test tests/Monolog/ConsoleLoggerTest.php

## Quality Analysis

|                         |                                                                                                                                                                                                                                                                                                                                                                                                                                       Branch 'master'                                                                                                                                                                                                                                                                                                                                                                                                                                       |                                                                                                                                                                                                                                                                                                                                                                                                                                        Branch 'develop'
|:------------------------|:-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:
| **Build**|||
| Github.com              | ![Commit Status Master](https://img.shields.io/github/check-runs/The-oGlow/ezlogging/master?logo=github&label=checks%20master&style=plastic "Commit Status Master") | ![Commit Status Develop](https://img.shields.io/github/check-runs/The-oGlow/ezlogging/develop?logo=github&label=checks%20develop&style=plastic "Commit Status Develop")                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |                                                                                                                                                                                                                                                                                                                                                                                                                                                
| **Quality Information**|||
| Sonarcloud.io           | [![Sonarcloud](https://sonarcloud.io/api/project_badges/quality_gate?project=The-oGlow_ezlogging)](https://sonarcloud.io/dashboard?id=The-oGlow_ezlogging) | - | 
| **Test Information**|||
| Sonarcloud.io           | [![Sonarcloud](https://img.shields.io/sonar/tests/The-oGlow_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=The-oGlow_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/test_success_density/The-oGlow_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=The-oGlow_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/coverage/The-oGlow_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=The-oGlow_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/violations/The-oGlow_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=The-oGlow_ezlogging)<br/> | [![Sonarcloud](https://img.shields.io/sonar/tests/The-oGlow_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=The-oGlow_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/test_success_density/The-oGlow_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=The-oGlow_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/coverage/The-oGlow_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=The-oGlow_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/violations/The-oGlow_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=The-oGlow_ezlogging)<br/>

[![SonarQube Cloud](https://sonarcloud.io/images/project_badges/sonarcloud-light.svg)](https://sonarcloud.io/summary/new_code?id=The-oGlow_ezlogging)

# Notice

- Nothing to notice
