<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\ArrayItem;
use PhpParser\Node\Expr\Array_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Check if keys in array are unique
 *
 * @implements Rule<Array_>
 */
class DuplicatedArrayKeys implements Rule
{
    public function getNodeType(): string
    {
        return Array_::class;
    }

    /**
     * @return array<int, \PHPStan\Rules\RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof Array_) {
            return [];
        }

        $errors = [];
        $existingKeys = [];

        foreach ($node->items as $item) {
            if (!$item instanceof ArrayItem || $item->key === null) {
                continue;
            }

            $key = $this->getKey($item->key);
            if ($key === null) {
                continue;
            }

            if (\in_array($key, $existingKeys, true)) {
                $errors[] = RuleErrorBuilder::message("Array key '$key' is duplicated.")
                    ->identifier('extraDuplicatedArrayKeys')
                    ->line($item->key->getLine())
                    ->build();
                continue;
            }

            $existingKeys[] = $key;
        }

        return $errors;
    }

    private function getKey(Node $node): string|int|null
    {
        if ($node instanceof Node\Scalar\String_) {
            $arr = [$node->value => 1];

            return \array_key_first($arr);
        }

        if ($node instanceof Node\Scalar\Int_) {
            return $node->value;
        }

        if ($node instanceof Node\Scalar\Float_) {
            return (int) $node->value;
        }

        return null;
    }
}
