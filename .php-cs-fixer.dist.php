<?php

declare(strict_types=1);

$header = <<<EOF
This file is part of ezlogging

(c) 2025 Oliver Glowa, coding.glowa.com

This source file is subject to the Apache-2.0 license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = PhpCsFixer\Finder::create()->in(__DIR__ . '/src')->in(__DIR__ . '/tests');

return (new PhpCsFixer\Config())->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())->setRules(
    [
        '@PSR2'                           => true,
        '@PSR12'                          => true,
        'declare_strict_types'            => true,
        'no_trailing_comma_in_singleline' => true,
        'protected_to_private'            => false,
        'visibility_required'             => false,
        'class_attributes_separation'     => [
            'elements' => [
                'const'        => 'only_if_meta',
                'trait_import' => 'none',
                'property'     => 'only_if_meta'
            ]
        ],
        'blank_line_before_statement'     => [
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
        'no_extra_blank_lines'            => [
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
        'statement_indentation'           => ['stick_comment_to_next_continuous_control_statement' => true],
        'header_comment'                  => ['header' => $header]

    ]
)->setFinder($finder);

