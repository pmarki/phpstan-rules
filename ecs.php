<?php declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (\Symplify\EasyCodingStandard\Config\ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);
    $ecsConfig->skip([
        __DIR__ . '/tests/fixtures',
    ]);
    $ecsConfig->sets([SetList::PSR_12, SetList::NAMESPACES, SetList::DOCBLOCK]);

    $ecsConfig->rules([
    ]);
};
