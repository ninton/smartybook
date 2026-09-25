<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/lib/PearStub',
        __DIR__ . '/smartybook',
        __DIR__ . '/tests',
    ])
    ->exclude(['templates_c', 'vendor']);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'single_quote' => true,
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(false);
