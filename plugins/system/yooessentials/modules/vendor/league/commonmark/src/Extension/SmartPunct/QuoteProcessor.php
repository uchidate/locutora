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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\DelimiterInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractStringContainer;
final class QuoteProcessor implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface
{
    /** @var string */
    private $normalizedCharacter;
    /** @var string */
    private $openerCharacter;
    /** @var string */
    private $closerCharacter;
    private function __construct(string $char, string $opener, string $closer)
    {
        $this->normalizedCharacter = $char;
        $this->openerCharacter = $opener;
        $this->closerCharacter = $closer;
    }
    public function getOpeningCharacter() : string
    {
        return $this->normalizedCharacter;
    }
    public function getClosingCharacter() : string
    {
        return $this->normalizedCharacter;
    }
    public function getMinLength() : int
    {
        return 1;
    }
    public function getDelimiterUse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\DelimiterInterface $opener, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\DelimiterInterface $closer) : int
    {
        return 1;
    }
    public function process(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractStringContainer $opener, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractStringContainer $closer, int $delimiterUse)
    {
        $opener->insertAfter(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote($this->openerCharacter));
        $closer->insertBefore(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote($this->closerCharacter));
    }
    /**
     * Create a double-quote processor
     *
     * @param string $opener
     * @param string $closer
     *
     * @return QuoteProcessor
     */
    public static function createDoubleQuoteProcessor(string $opener = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE_OPENER, string $closer = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE_CLOSER) : self
    {
        return new self(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE, $opener, $closer);
    }
    /**
     * Create a single-quote processor
     *
     * @param string $opener
     * @param string $closer
     *
     * @return QuoteProcessor
     */
    public static function createSingleQuoteProcessor(string $opener = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE_OPENER, string $closer = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE_CLOSER) : self
    {
        return new self(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE, $opener, $closer);
    }
}
