<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Normalizer;

/***
 * Normalize text input using the steps given by the CommonMark spec to normalize labels
 *
 * @see https://spec.commonmark.org/0.29/#matches
 */
final class TextNormalizer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Normalizer\TextNormalizerInterface
{
    /**
     * @var array<int, array<int, string>>
     *
     * Source: https://github.com/symfony/polyfill-mbstring/blob/master/Mbstring.php
     */
    private const CASE_FOLD = [['µ', 'ſ', "ͅ", 'ς', "ϐ", "ϑ", "ϕ", "ϖ", "ϰ", "ϱ", "ϵ", "ẛ", "ι", "ß", "ẞ"], ['μ', 's', 'ι', 'σ', 'β', 'θ', 'φ', 'π', 'κ', 'ρ', 'ε', "ṡ", 'ι', 'ss', 'ss']];
    /**
     * {@inheritdoc}
     */
    public function normalize(string $text, $context = null) : string
    {
        // Collapse internal whitespace to single space and remove
        // leading/trailing whitespace
        $text = \preg_replace('/\\s+/', ' ', \trim($text));
        if (!\defined('MB_CASE_FOLD')) {
            // We're not on a version of PHP (7.3+) which has this feature
            $text = \str_replace(self::CASE_FOLD[0], self::CASE_FOLD[1], $text);
            return \mb_strtolower($text, 'UTF-8');
        }
        return \mb_convert_case($text, \MB_CASE_FOLD, 'UTF-8');
    }
}
