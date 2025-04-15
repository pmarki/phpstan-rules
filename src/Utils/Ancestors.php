<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Utils;

use PHPStan\Analyser\Scope;

class Ancestors
{
    public function methodInherited(string $methodName, Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();
        if (!$scope->isInClass()) {
            return false;
        }

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
