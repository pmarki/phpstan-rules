<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PMarki\PHPStanRules\Utils\Ancestors;

/**
 * @implements Rule<FunctionLike>
 */
class ExcessiveParameterListRule implements Rule
{
    public function __construct(
        private readonly Ancestors $ancestors,
        private readonly int $maxNumberOfParameters,
    ) {
    }

    public function getNodeType(): string
    {
        return FunctionLike::class;
    }

    /**
     * @return array<int, \PHPStan\Rules\RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof FunctionLike) {
            return [];
        }

        if ($node->name instanceof Node\Identifier && $this->ancestors->methodInherited($node->name->name, $scope)) {
            return [];
        }

        $numberOfParams = count($node->getParams());
        if ($numberOfParams > $this->maxNumberOfParameters) {
            return [
                RuleErrorBuilder::message(
                    sprintf(
                        'Too many parameters in function declaration, expected %s, found %s.',
                        $this->maxNumberOfParameters,
                        $numberOfParams,
                    )
                )->tip('Create a new object to wrap the numerous parameters.')
                    ->identifier('extraExcessiveParameterList')
                    ->build(),
            ];
        }

        return [];
    }
}
