<?php

declare(strict_types=1);

$finder = new PhpCsFixer\Finder()
    ->in(__DIR__)
    ->exclude('var');

return new PhpCsFixer\Config()
    ->setRules([
        '@PHP84Migration' => true,
        '@PHP82Migration:risky' => true,
        '@PHPUnit100Migration:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        // Override rules from Symfony
        'concat_space' => ['spacing' => 'one'], // fixes PER coding standard violation
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => false,
            'import_functions' => false,
        ], // add global classes to import list, but not global constants/functions
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'], // disallow multiple args on the same line
        'phpdoc_align' => ['align' => 'left'], // left alignment instead of vertical
        'phpdoc_separation' => false, // no empty lines between annotations
        'single_line_throw' => false, // no reason to disallow multi-line exceptions
        'single_quote' => ['strings_containing_single_quote_chars' => true], // always use single quotes
        'yoda_style' => false, // not useful because of the strict_comparison rule
        // Override rules from Symfony:risky
        'native_constant_invocation' => false, // performance improvement is non-existent since php 7
        'native_function_invocation' => false, // performance improvement is non-existent since php 7
        // New rules
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
                'property' => 'none',
                'trait_import' => 'none',
                'case' => 'none',
            ],
        ], // spacing between class attributes (one space for methods, no space otherwise)
        'comment_to_phpdoc' => true, // comments with annotation should be docblock when used on structural elements
        'final_class' => true, // all classes must be final, except abstract ones and Doctrine entities
        'general_phpdoc_annotation_remove' => [
            'annotations' => ['author', 'category', 'copyright', 'license', 'package', 'since', 'subpackage', 'version'],
        ], // removes the specified annotations
        'no_useless_else' => true, // disallow useless else cases
        'no_useless_return' => true, // disallow useless return statements
        'php_unit_strict' => true, // PHPUnit methods like assertSame should be used instead of assertEquals
        'phpdoc_line_span' => true, // Changes doc blocks from single to multi line
        'protected_to_private' => true, // converts protected variables and methods to private where possible
        'strict_comparison' => true, // comparisons should be strict (=== and !==)
        'strict_param' => true, // functions should be used with $strict param set to true (e.g. in_array)
        'void_return' => true, // adds void return type to functions with missing or empty return statements
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect());
