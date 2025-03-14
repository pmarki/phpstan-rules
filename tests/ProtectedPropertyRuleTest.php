<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PMarki\PHPStanRules\Rules\ProtectedPropertyRule;

class ProtectedPropertyRuleTest extends RuleTestCase
{
    private const TIP = "\n    💡 Protected properties can be used only in Abstract classes or when inherited.";

    public function testNoAbstractClass(): void
    {
        $this->analyse(
            [__DIR__ . '/fixtures/ProtectedPropertyRule/NoAbstractClass.php'],
            [
                [
                    'Property $protectedProperty should have private visibility.' . self::TIP,
                    6,
                ],
                [
                    'Property name $_nameWithUnderscore must not start with underscore.',
                    13,
                ],
                [
                    'Property $protectedPromoted should have private visibility.' . self::TIP,
                    17,
                ],
            ],
        );
    }

    public function testAbstractClass(): void
    {
        $this->analyse(
            [__DIR__ . '/fixtures/ProtectedPropertyRule/AbstractClass.php'],
            [
                [
                    'Property name $_nameWithUnderscore must not start with underscore.',
                    13,
                ],
            ],
        );
    }

    public function testChildClass(): void
    {
        $this->analyse(
            [
                __DIR__ . '/fixtures/ProtectedPropertyRule/ChildClass.php',
            ],
            [
                [
                    'Property $protectedChild should have private visibility.' . self::TIP,
                    9,
                ],
                [
                    'Property name $_nameWithUnderscore must not start with underscore.',
                    14,
                ],

                [
                    'Property $protectedChildPromoted should have private visibility.' . self::TIP,
                    19,
                ],
            ],
        );
    }

    protected function getRule(): Rule
    {
        return new ProtectedPropertyRule();
    }
}
