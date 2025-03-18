<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\Node\ClassPropertyNode;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Reports an error when a property is protected in a non-abstract class,
 * unless it is inherited from a parent class or interface
 * or when name starts with underscore
 *
 * @implements Rule<ClassPropertyNode>
 */
class ProtectedPropertyRule implements Rule
{
    public function getNodeType(): string
    {
        return ClassPropertyNode::class;
    }

    /**
     * @return array<int, \PHPStan\Rules\RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof ClassPropertyNode) {
            return [];
        }

        $errors = [];
        $propertyName = $node->getName();
        if ($this->propertyInherited($propertyName, $scope)) {
            return [];
        }

        if (\str_starts_with($propertyName, '_')) {
            $errors[] = RuleErrorBuilder::message("Property name \${$propertyName} must not start with underscore.")
                ->identifier('extraPropertyRules')
                ->build();
        }

        if (!$this->isInAbstractClass($scope) && $node->isProtected()) {
            $errors[] = RuleErrorBuilder::message("Property \${$propertyName} should have private visibility.")
                ->identifier('extraPropertyRules')
                ->tip("Protected properties can be used only in Abstract classes or when inherited.")
                ->build();
        }

        return $errors;
    }

    private function isInAbstractClass(Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();
        return $classReflection === null || $classReflection->isAbstract();
    }

    private function propertyInherited(string $propertyName, Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();

        foreach (\array_merge($classReflection->getParents(), $classReflection->getInterfaces()) as $ancestor) {
            if ($ancestor->hasProperty($propertyName)) {
                $property = $ancestor->getProperty($propertyName, $scope);

                if (!$property->isPrivate()) {
                    return true;
                }
            }
        }

        return false;
    }
}
