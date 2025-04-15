<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPStan\Type\FileTypeMapper;
use PMarki\PHPStanRules\Rules\BooleanArgumentFlagRule;
use PMarki\PHPStanRules\Utils\Ancestors;

class BooleanArgumentFlagRuleTest extends RuleTestCase
{
    private const TIP = "\n    💡 Extract the logic in the boolean flag into its own class or method.";

    public function testBooleanArgumentFlag(): void
    {
        $this->analyse(
            [
                __DIR__ . '/fixtures/BooleanArgumentFlagRule.php',
            ],
            [
                [
                    "Boolean flag '\$bool' indicates violation of Single Responsibility Principle." . self::TIP,
                    5,
                ],
                [
                    "Boolean flag '\$bool1' indicates violation of Single Responsibility Principle." . self::TIP,
                    9,
                ],
                [
                    "Boolean flag '\$bool2' indicates violation of Single Responsibility Principle." . self::TIP,
                    9,
                ],
                [
                    "Boolean flag '\$bool' indicates violation of Single Responsibility Principle." . self::TIP,
                    28,
                ],
                [
                    "Boolean flag '\$bool' indicates violation of Single Responsibility Principle." . self::TIP,
                    41,
                ],
            ],
        );
    }

    protected function getRule(): Rule
    {
        return new BooleanArgumentFlagRule(
            new Ancestors(),
            self::getContainer()->getByType(FileTypeMapper::class)
        );
    }
}
