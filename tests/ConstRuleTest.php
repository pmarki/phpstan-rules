<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PMarki\PHPStanRules\Rules\ConstRule;

class ConstRuleTest extends RuleTestCase
{
    private const TIP = "\n    💡 Protected constants can be used only in Abstract classes or when inherited.";

    public function testNoAbstractClass(): void
    {
        $this->analyse(
            [__DIR__ . '/fixtures/ConstRule/NoAbstractClass.php'],
            [
                [
                    'Missing visibility keyword for class constant ABC.',
                    6,
                ],
                [
                    'There can be only one constant declared per statement.',
                    7,
                ],
                [
                    'Constant PROTECTED_CONST should have private visibility.' . self::TIP,
                    10,
                ],
                [
                    'Constant name lowercase must be uppercase.',
                    11,
                ],
                [
                    'Missing visibility keyword for class constant foo.',
                    12,
                ],
                [
                    'Constant name foo must be uppercase.',
                    12,
                ],
            ],
        );
    }

    public function testAbstractClass(): void
    {
        $this->analyse(
            [__DIR__ . '/fixtures/ConstRule/AbstractClass.php'],
            [
                [
                    'Missing visibility keyword for class constant ABC.',
                    6,
                ],
                [
                    'There can be only one constant declared per statement.',
                    7,
                ],
                [
                    'Constant name lowercase must be uppercase.',
                    11,
                ],
                [
                    'Missing visibility keyword for class constant foo.',
                    12,
                ],
                [
                    'Constant name foo must be uppercase.',
                    12,
                ],
            ],
        );
    }

    public function testChildClass(): void
    {
        $this->analyse(
            [
                __DIR__ . '/fixtures/ConstRule/ChildClass.php',
            ],
            [
                [
                    'There can be only one constant declared per statement.',
                    7,
                ],
                [
                    'Constant CHILD_PROTECTED_CONST should have private visibility.' . self::TIP,
                    11,
                ],
                [
                    'Constant name child_lowercase must be uppercase.',
                    15,
                ],
                [
                    'Missing visibility keyword for class constant child_foo.',
                    16,
                ],
                [
                    'Constant name child_foo must be uppercase.',
                    16,
                ],
            ],
        );
    }

    protected function getRule(): Rule
    {
        return new ConstRule();
    }
}
