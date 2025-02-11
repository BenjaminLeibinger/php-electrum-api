<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withRules([
        TypedPropertyFromStrictConstructorRector::class
    ])
    ->withPhpVersion(Rector\ValueObject\PhpVersion::PHP_84)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        earlyReturn: true,
        symfonyCodeQuality: true,
        symfonyConfigs: true
    );
//    ->withTypeCoverageLevel(0)
//    ->withDeadCodeLevel(0)
//    ->withCodeQualityLevel(0);
