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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer as CoreBlockRenderer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer as CoreInlineRenderer;
final class SmartPunctExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment)
    {
        $environment->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\QuoteParser(), 10)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\PunctuationParser(), 0)->addDelimiterProcessor(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\QuoteProcessor::createDoubleQuoteProcessor($environment->getConfig('smartpunct/double_quote_opener', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE_OPENER), $environment->getConfig('smartpunct/double_quote_closer', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::DOUBLE_QUOTE_CLOSER)))->addDelimiterProcessor(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\QuoteProcessor::createSingleQuoteProcessor($environment->getConfig('smartpunct/single_quote_opener', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE_OPENER), $environment->getConfig('smartpunct/single_quote_closer', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::SINGLE_QUOTE_CLOSER)))->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\DocumentRenderer(), 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\ParagraphRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\Quote::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\SmartPunct\QuoteRenderer(), 100)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\TextRenderer(), 0);
    }
}
