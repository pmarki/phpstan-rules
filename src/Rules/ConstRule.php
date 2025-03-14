<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Rules;

use PhpParser\Modifiers;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassConst;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassConst>
 */
class ConstRule implements Rule
{
    public function getNodeType(): string
    {
        return ClassConst::class;
    }

    /**
     * @return array<int, \PHPStan\Rules\RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof ClassConst) {
            return [];
        }

        // first lets check if every constant is in separate line
        if (\count($node->consts) > 1) {
            return [
                RuleErrorBuilder::message("There can be only one constant declared per statement.")
                    ->identifier('extraConstRule')
                    ->build(),
            ];
        }

        $errors = [];
        $constName = $node->consts[0]->name->toString();
        $isInherited = $this->constantInherited($constName, $scope);

        if ($isInherited) {
            return [];
        }

        if ($node->flags === Modifiers::PROTECTED && !$this->isInAbstractClass($scope)) {
            $errors[] = RuleErrorBuilder::message("Constant {$constName} should have private visibility.")
                ->identifier('extraConstRule')
                ->tip("Protected constants can be used only in Abstract classes or when inherited.")
                ->build();
        }

        if ($node->flags === 0) {
            $errors[] = RuleErrorBuilder::message("Missing visibility keyword for class constant {$constName}.")
                ->identifier('extraConstRule')
                ->build();
        }

        if ($constName !== \strtoupper($constName)) {
            $errors[] = RuleErrorBuilder::message("Constant name {$constName} must be uppercase.")
                ->identifier('extraConstRule')
                ->build();
        }

        return $errors;
    }

    private function isInAbstractClass(Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();
        return $classReflection === null || $classReflection->isAbstract();
    }

    private function constantInherited(string $constName, Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();

        foreach (\array_merge($classReflection->getParents(), $classReflection->getInterfaces()) as $ancestor) {
            try {
                $ancestor->getConstant($constName);
                return true;
            } catch (\PHPStan\Reflection\MissingConstantFromReflectionException) {
                continue;
            }
        }

        return false;
    }
}
