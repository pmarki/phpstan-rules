<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PMarki\PHPStanRules\Rules\DuplicatedArrayKeys;

class DuplicatedArrayKeysTest extends RuleTestCase
{
    public function testNoAbstractClass(): void
    {
        $this->analyse(
            [__DIR__ . '/fixtures/DuplicatedArrayKeys.php'],
            [
                [
                    "Array key 'key1' is duplicated.",
                    6,
                ],
                [
                    "Array key '2' is duplicated.",
                    12,
                ],
                [
                    "Array key 'nested-key2' is duplicated.",
                    30,
                ],
            ],
        );
    }

    protected function getRule(): Rule
    {
        return new DuplicatedArrayKeys();
    }
}
