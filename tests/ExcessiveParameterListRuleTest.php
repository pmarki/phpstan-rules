<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PMarki\PHPStanRules\Rules\ExcessiveParameterListRule;
use PMarki\PHPStanRules\Utils\Ancestors;

class ExcessiveParameterListRuleTest extends RuleTestCase
{
    private const MAX_NUMBER_OF_PARAMS = 10;
    private const TIP = "\n    💡 Create a new object to wrap the numerous parameters.";

    public function testExcessiveParameterListRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/fixtures/ExcessiveParameterListRule.php',
            ],
            [
                [
                    sprintf(
                        "Too many parameters in function declaration, expected %s, found 11.%s",
                        self::MAX_NUMBER_OF_PARAMS,
                        self::TIP,
                    ),
                    6,
                ],
                [
                    sprintf(
                        "Too many parameters in function declaration, expected %s, found 11.%s",
                        self::MAX_NUMBER_OF_PARAMS,
                        self::TIP,
                    ),
                    34,
                ],
            ],
        );
    }

    protected function getRule(): Rule
    {
        return new ExcessiveParameterListRule(
            new Ancestors(),
            self::MAX_NUMBER_OF_PARAMS,
        );
    }
}
