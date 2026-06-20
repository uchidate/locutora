<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (http://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Delimiter;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper;
final class QuoteParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface
{
    public const DOUBLE_QUOTES = [\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE_OPENER, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE_CLOSER];
    public const SINGLE_QUOTES = [\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE_OPENER, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE_CLOSER];
    /**
     * @return string[]
     */
    public function getCharacters() : array
    {
        return \array_merge(self::DOUBLE_QUOTES, self::SINGLE_QUOTES);
    }
    /**
     * Normalizes any quote characters found and manually adds them to the delimiter stack
     */
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineContext) : bool
    {
        $cursor = $inlineContext->getCursor();
        $normalizedCharacter = $this->getNormalizedQuoteCharacter($cursor->getCharacter());
        $charBefore = $cursor->peek(-1);
        if ($charBefore === null) {
            $charBefore = "\n";
        }
        $cursor->advance();
        $charAfter = $cursor->getCharacter();
        if ($charAfter === null) {
            $charAfter = "\n";
        }
        [$leftFlanking, $rightFlanking] = $this->determineFlanking($charBefore, $charAfter);
        $canOpen = $leftFlanking && !$rightFlanking;
        $canClose = $rightFlanking;
        $node = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote($normalizedCharacter, ['delim' => \true]);
        $inlineContext->getContainer()->appendChild($node);
        // Add entry to stack to this opener
        $inlineContext->getDelimiterStack()->push(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Delimiter($normalizedCharacter, 1, $node, $canOpen, $canClose));
        return \true;
    }
    private function getNormalizedQuoteCharacter(string $character) : string
    {
        if (\in_array($character, self::DOUBLE_QUOTES)) {
            return \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE;
        } elseif (\in_array($character, self::SINGLE_QUOTES)) {
            return \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE;
        }
        return $character;
    }
    /**
     * @param string $charBefore
     * @param string $charAfter
     *
     * @return bool[]
     */
    private function determineFlanking(string $charBefore, string $charAfter)
    {
        $afterIsWhitespace = \preg_match('/\\pZ|\\s/u', $charAfter);
        $afterIsPunctuation = \preg_match(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::REGEX_PUNCTUATION, $charAfter);
        $beforeIsWhitespace = \preg_match('/\\pZ|\\s/u', $charBefore);
        $beforeIsPunctuation = \preg_match(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::REGEX_PUNCTUATION, $charBefore);
        $leftFlanking = !$afterIsWhitespace && !($afterIsPunctuation && !$beforeIsWhitespace && !$beforeIsPunctuation);
        $rightFlanking = !$beforeIsWhitespace && !($beforeIsPunctuation && !$afterIsWhitespace && !$afterIsPunctuation);
        return [$leftFlanking, $rightFlanking];
    }
}
