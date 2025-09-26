<?php

declare(strict_types=1);

$headerProjName   = 'ezlogging';
$headerProjAuthor = 'Oliver Glowa, coding.glowa.com';
$headerProjYear   = 2025;
$headerText       = <<<EOF
This file is part of ${headerProjName}

(c) ${headerProjYear} ${headerProjAuthor}

This source file is subject to the Apache-2.0 license that is bundled
with this source code in the file LICENSE.
EOF;

$projRules = [
    // Rulsets
    '@PSR2'                                         => true,
    '@PSR12'                                        => true,
    // Customizing
    'declare_strict_types'                          => true,
    'no_trailing_comma_in_singleline'               => true,
    'protected_to_private'                          => false,
    'visibility_required'                           => false,
    'return_assignment'                             => true,
    // Blank lines / spacing
    'class_attributes_separation'                   => [
        'elements' => [
            'const'        => 'one',
            'method'       => 'one',
            'property'     => 'one',
            'trait_import' => 'none',
            'case'         => 'none'
        ]
    ],
    'blank_line_before_statement'                   => [
        'statements' => [
            'declare',
            'exit',
            'goto',
            'include',
            'include_once',
            'require',
            'require_once',
            'return',
            'try'
        ]
    ],
    'no_extra_blank_lines'                          => [
        'tokens' => [
            'attribute',
            'break',
            'case',
            'comma',
            'continue',
            'curly_brace_block',
            'default',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'switch',
            'throw'
        ]
    ],
    'statement_indentation'                         => ['stick_comment_to_next_continuous_control_statement' => true],
    // Comments
    'multiline_comment_opening_closing'             => true,
    'no_empty_comment'                              => true,
    'single_line_comment_spacing'                   => true,
    'single_line_comment_style'                     => true,
    'align_multiline_comment'                       => ['comment_type' => 'phpdocs_like'],
    // PHPDoc
    'no_blank_lines_after_phpdoc'                   => true,
    'no_empty_phpdoc'                               => true,
    'phpdoc_add_missing_param_annotation'           => true,
    'phpdoc_align'                                  => [
        'align' => 'vertical',
        'tags'  => [
            'method',
            'param',
            'property',
            'return',
            'throws',
            'type',
            'var',
            'property-read',
            'property-write',
            'phpstan-param',
            'phpstan-property',
            'phpstan-property-read',
            'phpstan-property-write',
            'phpstan-assert',
            'phpstan-assert-if-true',
            'phpstan-assert-if-false',
            'psalm-param',
            'psalm-param-out',
            'psalm-property',
            'psalm-property-read',
            'psalm-property-write',
            'psalm-assert',
            'psalm-assert-if-true',
            'psalm-assert-if-false',
            'phpstan-method',
            'psalm-method'
        ]
    ],
    'phpdoc_annotation_without_dot'                 => true,
    'phpdoc_indent'                                 => true,
    'phpdoc_inline_tag_normalizer'                  => true,
    'phpdoc_line_span'                              => ['property' => 'single', 'const' => 'single', 'method' => 'multi'],
    'phpdoc_no_access'                              => true,
    'phpdoc_no_alias_tag'                           => true,
    'phpdoc_no_empty_return'                        => true,
    'phpdoc_no_package'                             => true,
    'phpdoc_no_useless_inheritdoc'                  => true,
    'phpdoc_order'                                  => ['order' => ['param', 'return', 'throws']],
    'phpdoc_param_order'                            => true,
    'phpdoc_return_self_reference'                  => true,
    'phpdoc_scalar'                                 => true,
    'phpdoc_separation'                             => [
        'groups' => [
            ['author', 'copyright', 'license'],
            ['category', 'package', 'subpackage'],
            ['property', 'property-read', 'property-write'],
            ['deprecated', 'link', 'see', 'since'],
            ['psalm-suppress', 'phpstan-ignore']
        ],
    ],
    'phpdoc_single_line_var_spacing'                => true,
    'phpdoc_summary'                                => true,
    'phpdoc_tag_type'                               => true,
    'phpdoc_to_comment'                             => ['ignored_tags' => ['phpstan-ignore', 'psalm-suppress']],
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'phpdoc_trim'                                   => true,
    'phpdoc_types'                                  => true,
    'phpdoc_types_order'                            => true,
    'phpdoc_var_annotation_correct_order'           => true,
    'phpdoc_var_without_name'                       => true,
    'header_comment'                                => ['header' => $headerText]
];

$finder = PhpCsFixer\Finder::create()->in(__DIR__ . '/src')->in(__DIR__ . '/tests');

return (new PhpCsFixer\Config())->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())->setRules($projRules)->setFinder($finder);

