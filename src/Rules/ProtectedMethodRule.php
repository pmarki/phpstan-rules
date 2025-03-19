<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Reports an error when a method is protected in a non-abstract class unless it is inherited from a parent class.
 *
 * @implements Rule<ClassMethod>
 */
class ProtectedMethodRule implements Rule
{
    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @return array<int, \PHPStan\Rules\RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof ClassMethod) {
            return [];
        }

        $errors = [];
        $methodName = $node->name->toString();
        if ($this->methodInherited($methodName, $scope)) {
            return [];
        }

        if (\str_starts_with($methodName, '_') && !\str_starts_with($methodName, '__')) {
            $errors[] = RuleErrorBuilder::message("Method {$methodName}() must not start with underscore.")
                ->identifier('extraMethodRules')
                ->build();
        }

        if ($node->isProtected() && !$this->isInAbstractClass($scope)) {
            $errors[] = RuleErrorBuilder::message("Method {$methodName}() should have private visibility.")
                ->identifier('extraMethodRules')
                ->tip("Protected methods can be used only in abstract classes or when inherited.")
                ->build();
        }

        return $errors;
    }

    private function isInAbstractClass(Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();
        return $classReflection === null || $classReflection->isAbstract();
    }

    private function methodInherited(string $methodName, Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();

        foreach (\array_merge($classReflection->getParents(), $classReflection->getInterfaces()) as $ancestor) {
            if ($ancestor->hasMethod($methodName)) {
                $method = $ancestor->getMethod($methodName, $scope);

                if (!$method->isPrivate()) {
                    return true;
                }
            }
        }

        return false;
    }
}
