<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\InlinesOnly;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser as BlockParser;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\EmphasisDelimiterProcessor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element as InlineElement;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser as InlineParser;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer as InlineRenderer;
final class InlinesOnlyExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment)
    {
        $childRenderer = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\InlinesOnly\ChildRenderer();
        $environment->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\LazyParagraphParser(), -200)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\NewlineParser(), 200)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\BacktickParser(), 150)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\EscapableParser(), 80)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\EntityParser(), 70)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\AutolinkParser(), 50)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\HtmlInlineParser(), 40)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\CloseBracketParser(), 30)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\OpenBracketParser(), 20)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\BangParser(), 10)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document::class, $childRenderer, 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph::class, $childRenderer, 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Code::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\CodeRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Emphasis::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\EmphasisRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\HtmlInline::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\HtmlInlineRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Image::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\ImageRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Link::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\LinkRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Newline::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\NewlineRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Strong::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\StrongRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\TextRenderer(), 0);
        if ($environment->getConfig('use_asterisk', \true)) {
            $environment->addDelimiterProcessor(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\EmphasisDelimiterProcessor('*'));
        }
        if ($environment->getConfig('use_underscore', \true)) {
            $environment->addDelimiterProcessor(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\EmphasisDelimiterProcessor('_'));
        }
    }
}
