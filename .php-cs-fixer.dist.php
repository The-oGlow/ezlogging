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
        '@PSR12'                          => true,
        'declare_strict_types'            => true,
        'no_trailing_comma_in_singleline' => true,
        'protected_to_private'            => false,
        'visibility_required'             => false,
        'braces_position'                 => [
            'classes_opening_brace'            => 'next_line_unless_newline_at_signature_end',
            'control_structures_opening_brace' => 'next_line_unless_newline_at_signature_end',
            'functions_opening_brace'          => 'next_line_unless_newline_at_signature_end'
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
        'header_comment'                  => ['header' => $header]

    ]
)->setFinder($finder);

