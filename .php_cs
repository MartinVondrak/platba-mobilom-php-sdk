<?php

$fileHeaderComment = <<<COMMENT
PlatbaMobilom.sk PHP SDK

This file is part of PlatbaMobilom.sk PHP SDK.
See LICENSE file for full license details.

(c) 2019 Martin Vondrák
COMMENT;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'header_comment' => ['header' => $fileHeaderComment, 'separate' => 'bottom'],
        'linebreak_after_opening_tag' => true,
        'no_php4_constructor' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_imports' => true,
        'php_unit_strict' => true,
        'phpdoc_order' => true,
        'semicolon_after_instruction' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()->in(__DIR__)
    )
;
