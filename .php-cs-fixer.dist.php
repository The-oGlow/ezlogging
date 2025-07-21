<?php

declare(strict_types=1);

$header = <<<EOF
This file is part of ezlogging

(c) 2025 Oliver Glowa

This source file is subject to the Apache-2.0 license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = PhpCsFixer\Finder::create()->in(__DIR__ . '/src')->in(__DIR__ . '/tests');

return (new PhpCsFixer\Config())->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())->setRules(
    [
        '@PSR12'                          => true,
        'no_trailing_comma_in_singleline' => true,
        'protected_to_private'            => false,
        'visibility_required'             => false,
        //'header_comment'                  => ['header' => $header]

    ]
)->setFinder($finder);

