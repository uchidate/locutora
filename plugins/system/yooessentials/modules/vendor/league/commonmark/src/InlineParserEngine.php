<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (https://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractStringContainerBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Delimiter;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\AdjacentTextMerger;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceMapInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper;
/**
 * @internal
 */
final class InlineParserEngine
{
    /** @var EnvironmentInterface */
    protected $environment;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface $environment)
    {
        $this->environment = $environment;
    }
    /**
     * @param AbstractStringContainerBlock $container
     * @param ReferenceMapInterface        $referenceMap
     *
     * @return void
     */
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractStringContainerBlock $container, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceMapInterface $referenceMap)
    {
        $inlineParserContext = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext($container, $referenceMap);
        $cursor = $inlineParserContext->getCursor();
        while (($character = $cursor->getCharacter()) !== null) {
            if (!$this->parseCharacter($character, $inlineParserContext)) {
                $this->addPlainText($character, $container, $inlineParserContext);
            }
        }
        $this->processInlines($inlineParserContext);
        \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\AdjacentTextMerger::mergeChildNodes($container);
    }
    /**
     * @param string              $character
     * @param InlineParserContext $inlineParserContext
     *
     * @return bool Whether we successfully parsed a character at that position
     */
    private function parseCharacter(string $character, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineParserContext) : bool
    {
        foreach ($this->environment->getInlineParsersForCharacter($character) as $parser) {
            if ($parser->parse($inlineParserContext)) {
                return \true;
            }
        }
        if ($delimiterProcessor = $this->environment->getDelimiterProcessors()->getDelimiterProcessor($character)) {
            return $this->parseDelimiters($delimiterProcessor, $inlineParserContext);
        }
        return \false;
    }
    private function parseDelimiters(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface $delimiterProcessor, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineContext) : bool
    {
        $cursor = $inlineContext->getCursor();
        $character = $cursor->getCharacter();
        $numDelims = 0;
        $charBefore = $cursor->peek(-1);
        if ($charBefore === null) {
            $charBefore = "\n";
        }
        while ($cursor->peek($numDelims) === $character) {
            ++$numDelims;
        }
        if ($numDelims < $delimiterProcessor->getMinLength()) {
            return \false;
        }
        $cursor->advanceBy($numDelims);
        $charAfter = $cursor->getCharacter();
        if ($charAfter === null) {
            $charAfter = "\n";
        }
        list($canOpen, $canClose) = self::determineCanOpenOrClose($charBefore, $charAfter, $character, $delimiterProcessor);
        $node = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text(\str_repeat($character, $numDelims), ['delim' => \true]);
        $inlineContext->getContainer()->appendChild($node);
        // Add entry to stack to this opener
        if ($canOpen || $canClose) {
            $delimiter = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Delimiter($character, $numDelims, $node, $canOpen, $canClose);
            $inlineContext->getDelimiterStack()->push($delimiter);
        }
        return \true;
    }
    /**
     * @param InlineParserContext $inlineParserContext
     *
     * @return void
     */
    private function processInlines(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineParserContext)
    {
        $delimiterStack = $inlineParserContext->getDelimiterStack();
        $delimiterStack->processDelimiters(null, $this->environment->getDelimiterProcessors());
        // Remove all delimiters
        $delimiterStack->removeAll();
    }
    /**
     * @param string              $character
     * @param Node                $container
     * @param InlineParserContext $inlineParserContext
     *
     * @return void
     */
    private function addPlainText(string $character, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node $container, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineParserContext)
    {
        // We reach here if none of the parsers can handle the input
        // Attempt to match multiple non-special characters at once
        $text = $inlineParserContext->getCursor()->match($this->environment->getInlineParserCharacterRegex());
        // This might fail if we're currently at a special character which wasn't parsed; if so, just add that character
        if ($text === null) {
            $inlineParserContext->getCursor()->advanceBy(1);
            $text = $character;
        }
        $lastInline = $container->lastChild();
        if ($lastInline instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text && !isset($lastInline->data['delim'])) {
            $lastInline->append($text);
        } else {
            $container->appendChild(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text($text));
        }
    }
    /**
     * @param string                      $charBefore
     * @param string                      $charAfter
     * @param string                      $character
     * @param DelimiterProcessorInterface $delimiterProcessor
     *
     * @return bool[]
     */
    private static function determineCanOpenOrClose(string $charBefore, string $charAfter, string $character, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface $delimiterProcessor)
    {
        $afterIsWhitespace = \preg_match(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::REGEX_UNICODE_WHITESPACE_CHAR, $charAfter);
        $afterIsPunctuation = \preg_match(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::REGEX_PUNCTUATION, $charAfter);
        $beforeIsWhitespace = \preg_match(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::REGEX_UNICODE_WHITESPACE_CHAR, $charBefore);
        $beforeIsPunctuation = \preg_match(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::REGEX_PUNCTUATION, $charBefore);
        $leftFlanking = !$afterIsWhitespace && (!$afterIsPunctuation || $beforeIsWhitespace || $beforeIsPunctuation);
        $rightFlanking = !$beforeIsWhitespace && (!$beforeIsPunctuation || $afterIsWhitespace || $afterIsPunctuation);
        if ($character === '_') {
            $canOpen = $leftFlanking && (!$rightFlanking || $beforeIsPunctuation);
            $canClose = $rightFlanking && (!$leftFlanking || $afterIsPunctuation);
        } else {
            $canOpen = $leftFlanking && $character === $delimiterProcessor->getOpeningCharacter();
            $canClose = $rightFlanking && $character === $delimiterProcessor->getClosingCharacter();
        }
        return [$canOpen, $canClose];
    }
}
