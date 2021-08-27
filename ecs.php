<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(SetList::CLEAN_CODE);

    $containerConfigurator->import(SetList::SYMFONY);

    $containerConfigurator->import(SetList::PSR_12);

    $containerConfigurator->import(SetList::SYMPLIFY);

    $parameters = $containerConfigurator->parameters();

    $parameters->set('skip', [
        'SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff.UnusedVariable' => null,
        'SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff.UnusedMethod' => ['tests/Integration/Presentation/Cli/QueryCommandTest.php'],
        'PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer' => null,
    ]);
};
