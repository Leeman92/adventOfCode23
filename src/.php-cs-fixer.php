<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__ . '/App')
;

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    '@PhpCsFixer' => true,
    '@Symfony' => true,
    'strict_param' => true,
    'declare_strict_types' => true,
    'strict_comparison' => true,
    'single_quote' => true,
    'array_syntax' => ['syntax' => 'short'],
    'array_indentation' => true,
    'blank_line_before_statement' => true,
    'compact_nullable_type_declaration' => true,
    'no_extra_blank_lines' => true,
    'yoda_style' => [
        'equal' => false,
        'identical' => false,
    ],
    'method_chaining_indentation' => true,

])
    ->setFinder($finder)
    ;