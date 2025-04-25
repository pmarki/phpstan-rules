<?php

declare(strict_types=1);

namespace PMarki\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\FileTypeMapper;
use PMarki\PHPStanRules\Utils\Ancestors;

/**
 * @implements Rule<FunctionLike>
 */
class BooleanArgumentFlagRule implements Rule
{
    public function __construct(
        private readonly FileTypeMapper $fileTypeMapper,
        private readonly Ancestors $ancestors,
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

        $errors = [];

        foreach ($node->getParams() as $param) {
            if (!$param->type instanceof Node\Identifier || !$param->var instanceof Node\Expr\Variable) {
                continue;
            }
            $argName = $param->var->name;

            if ($param->type->toString() === 'bool') {
                $errors[] = RuleErrorBuilder::message(
                    "Boolean flag '\${$argName}' indicates violation of Single Responsibility Principle."
                )->tip('Extract the logic in the boolean flag into its own class or method.')
                    ->identifier('extraBooleanArgumentFlag')
                    ->build();
            }
        }

        foreach ($this->getTypeFromDocBlock($scope, $node) as $paramName) {
            $errors[] = RuleErrorBuilder::message(
                "Boolean flag '{$paramName}' indicates violation of Single Responsibility Principle."
            )->tip('Extract the logic in the boolean flag into its own class or method.')
                ->identifier('extraBooleanArgumentFlag')
                ->build();
        }


        return $errors;
    }

    private function getTypeFromDocBlock(Scope $scope, Node $node): array
    {
        if ($node->getDocComment() === null) {
            return [];
        }

        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc(
            $scope->getFile(),
            $scope->isInClass() ? $scope->getClassReflection()->getName() : null,
            $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null,
            $scope->getFunctionName(),
            $node->getDocComment()->getText(),
        );

        $docNodes = $resolvedPhpDoc->getPhpDocNodes();
        $types = [];
        foreach ($docNodes as $docNode) {
            $params = $docNode->getTagsByName('@param');
            foreach ($params as $param) {
                if ($param->value->type->name === 'bool') {
                    $types[] = $param->value->parameterName;
                }
            }
        }

        return $types;



        $docNodes = $resolvedPhpDoc->getParamTags();
        if ($docNodes === false) {
            return [];
        }

        $types = [];
        /** @var \PHPStan\PhpDoc\Tag\ParamTag $docNode */
        foreach ($docNodes as $docNode) {
            $type = $docNode->getType();
            if (!$type->isBoolean()->yes()) {
                continue;
            }
        }

        return $types;
    }
}
