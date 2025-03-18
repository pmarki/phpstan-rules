<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PMarki\PHPStanRules\Rules\ProtectedMethodRule;

class ProtectedMethodRuleTest extends RuleTestCase
{
    private const TIP = "\n    💡 Protected methods can be used only in abstract classes or when inherited.";

    public function testNoAbstractClass(): void
    {
        $this->analyse(
            [__DIR__ . '/fixtures/ProtectedMethodRule/NoAbstractClass.php'],
            [
                [
                    'Method protectedMethod() should have private visibility.' . self::TIP,
                    6,
                ],
                [
                    'Method _underscore() must not start with underscore.',
                    9,
                ],
                [
                    'Method _underscoreProtected() must not start with underscore.',
                    10,
                ],
                [
                    'Method _underscoreProtected() should have private visibility.' . self::TIP,
                    10,
                ],
            ],
        );
    }

    public function testAbstractClass(): void
    {
        $this->analyse(
            [__DIR__ . '/fixtures/ProtectedMethodRule/AbstractClass.php'],
            [
                [
                    'Method _underscore() must not start with underscore.',
                    9,
                ],
                [
                    'Method _underscoreProtected() must not start with underscore.',
                    10,
                ],
            ],
        );
    }

    public function testChildClass(): void
    {
        $this->analyse(
            [
                __DIR__ . '/fixtures/ProtectedMethodRule/ChildClass.php',
            ],
            [
                [
                    'Method childMethod() should have private visibility.' . self::TIP,
                    8,
                ],
                [
                    'Method _underscore() must not start with underscore.',
                    11,
                ],
            ],
        );
    }

    public function testInterface(): void
    {
        $this->analyse(
            [
                __DIR__ . '/fixtures/ProtectedMethodRule/Interface.php',
            ],
            [
                [
                    'Method _underscoreProtected() must not start with underscore.',
                    7,
                ],
            ],
        );
    }

    protected function getRule(): Rule
    {
        return new ProtectedMethodRule();
    }
}
