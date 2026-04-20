<?php

declare(strict_types=1);

/*
 * This file is part of ezlogging
 *
 * (c) 2025 Oliver Glowa, coding.glowa.com
 *
 * This source file is subject to the Apache-2.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ollily\Tools;

use PHPUnit\Framework\TestCase;

class EnvironmentVariableTraitTest extends TestCase
{
    use EnvironmentVariableTrait;

    private const         PROJECT_NAME  = 'ezlogging';

    public function testHomeDefault(): void
    {
        $actual = self::getHome();

        $this->validateActualContains($actual, DIRECTORY_SEPARATOR);
    }

    public function testHomeUserProfileDirect(): void
    {
        $actual = self::getHome('USERPROFILE');
        if (empty($actual)) {
            $actual = self::getHome('HOME');
        }

        $this->validateActualContains($actual, DIRECTORY_SEPARATOR);
    }

    public function testHomeUserProfileIndirect(): void
    {
        $actual = self::getHome('NOTEXISTS');

        static::assertEquals("", $actual);
    }

    public function testGetProjectRoot(): void
    {
        $actual = self::getProjectRoot();

        $this->validateActualEnds($actual, self::PROJECT_NAME);
    }

    public function testGetComposerFilePath(): void
    {
        $actual = self::getComposerFilePath();

        $this->validateActualEnds($actual, self::PROJECT_NAME);
    }

    public function testGetProjectRootFallback(): void
    {
        $actual = self::getProjectRootFallback();

        $this->validateActualEnds($actual, self::PROJECT_NAME);
    }

    private function validateActualContains(string $actual, string $expected): void
    {
        echo "\nactual='$actual'\n";
        static::assertNotEmpty($actual);
        static::assertStringContainsString($expected, $actual);
    }

    private function validateActualEnds(string $actual, string $expected): void
    {
        echo "\nactual='$actual'\n";
        static::assertNotEmpty($actual);
        static::assertStringEndsWith($expected, $actual);
    }
}
