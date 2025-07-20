# Yet Another Confluence REST API

![Latest Version](https://img.shields.io/badge/release-latest-blue?logo=github&style=plastic "Latest Version")
![Software License](https://img.shields.io/github/license/ollily/ezlogging?logo=github&style=plastic "Software License")
![GitHub Release](https://img.shields.io/github/v/release/ollily/ezlogging?logo=github&style=plastic "GitHub Release")

![Language Count](https://img.shields.io/github/languages/count/ollily/ezlogging?logo=github&style=plastic "Language Count")
![Language Top](https://img.shields.io/github/languages/top/ollily/ezlogging?logo=github&style=plastic "Language Top")
![Commit Status Master](https://img.shields.io/github/checks-status/ollily/ezlogging/master?logo=github&label=checks%20master&style=plastic "Commit Status Master")
![Commit Status Develop](https://img.shields.io/github/checks-status/ollily/ezlogging/develop?logo=github&label=checks%20develop&style=plastic "Commit Status Develop")

(c) 2025 Oliver Glowa

# Description

Simplify the usage of logging with Monolog.

# Requirements

- Commandline
    - Linux / Unix Shell or
    - Windows Shell
- [PHP](https://www.php.net)
- [Composer](https://getcomposer.org/) (optional)

# Configuration

## Unix / Linux

- There is nothing to configure, you can use this library ootb

## Windows

- There is nothing to configure, you can use this library ootb

# How to use it

TBD

# Development

Some infos, in case you want to fork and extend this library,

## Structure

Relevant files and folders

    <project-root>
    |--src
    |  |-- Monolog
    |  |-- PHPUnit
    |
    |--tests
    |  |-- Monolog
    |  |-- PHPUnit
    |
    |--vendor
    |  |- *
    |
    |-composer.json
    |-composer.lock
    |-php-cs-fixer.php.dist
    |-phpstan.neon.dist
    |-phpunit.xml.dist
    |-README.md

## UNIT Tests

Starting the unit tests (PHP Unit)

    .composer c-test

## Quality Analysis

|                         |                                                                                                                                                                                                                                                                                                                                                                                                                                       Branch 'master'                                                                                                                                                                                                                                                                                                                                                                                                                                       |                                                                                                                                                                                                                                                                                                                                                                                                                                        Branch 'develop'
|:------------------------|:-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:
| **Build**
| Github.com              |                                                                                                                                                                                                                                                                                                                                                                                                                                              -                                                                                                                                                                                                                                                                                                                                                                                                                                              |                                                                                                                                                                                                                                                                                                                                                                                                                                                -
| **Quality Information**
| Sonarcloud.io           |                                                                                                                                                                                                                                                                                                                                                                                                                                              -                                                                                                                                                                                                                                                                                                                                                                                                                                              |                                                                                                                                                                                                                                                                                                                                                                      [![Sonarcloud](https://sonarcloud.io/api/project_badges/quality_gate?project=ollily_ezlogging)](https://sonarcloud.io/dashboard?id=ollily_ezlogging)
| **Test Information**
| Sonarcloud.io           | [![Sonarcloud](https://img.shields.io/sonar/tests/ollily_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=ollily_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/test_success_density/ollily_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=ollily_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/coverage/ollily_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=ollily_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/violations/ollily_ezlogging/master?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=ollily_ezlogging)<br/> | [![Sonarcloud](https://img.shields.io/sonar/tests/ollily_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=ollily_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/test_success_density/ollily_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=ollily_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/coverage/ollily_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=ollily_ezlogging)<br/>[![Sonarcloud](https://img.shields.io/sonar/violations/ollily_ezlogging/develop?server=https%3A%2F%2Fsonarcloud.io&compact_message&style=plastic&logo=sonar)](https://sonarcloud.io/dashboard?id=ollily_ezlogging)<br/>

[![SonarQube Cloud](https://sonarcloud.io/images/project_badges/sonarcloud-light.svg)](https://sonarcloud.io/summary/new_code?id=ollily_ezlogging)

# Notice

- Nothing to notice
