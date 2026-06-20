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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element as BlockElement;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser as BlockParser;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer as BlockRenderer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\EmphasisDelimiterProcessor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element as InlineElement;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser as InlineParser;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer as InlineRenderer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface;
final class CommonMarkCoreExtension implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\ExtensionInterface
{
    public function register(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockQuoteParser(), 70)->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\ATXHeadingParser(), 60)->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\FencedCodeParser(), 50)->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\HtmlBlockParser(), 40)->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\SetExtHeadingParser(), 30)->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\ThematicBreakParser(), 20)->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\ListParser(), 10)->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\IndentedCodeParser(), -100)->addBlockParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\LazyParagraphParser(), -200)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\NewlineParser(), 200)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\BacktickParser(), 150)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\EscapableParser(), 80)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\EntityParser(), 70)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\AutolinkParser(), 50)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\HtmlInlineParser(), 40)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\CloseBracketParser(), 30)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\OpenBracketParser(), 20)->addInlineParser(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\BangParser(), 10)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\BlockQuote::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\BlockQuoteRenderer(), 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\DocumentRenderer(), 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\FencedCode::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\FencedCodeRenderer(), 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\HeadingRenderer(), 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\HtmlBlock::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\HtmlBlockRenderer(), 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\IndentedCode::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\IndentedCodeRenderer(), 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\ListBlockRenderer(), 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\ListItemRenderer(), 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\ParagraphRenderer(), 0)->addBlockRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ThematicBreak::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\ThematicBreakRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Code::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\CodeRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Emphasis::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\EmphasisRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\HtmlInline::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\HtmlInlineRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Image::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\ImageRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Link::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\LinkRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Newline::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\NewlineRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Strong::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\StrongRenderer(), 0)->addInlineRenderer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text::class, new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\TextRenderer(), 0);
        $deprecatedUseAsterisk = $environment->getConfig('use_asterisk', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface::MISSING);
        if ($deprecatedUseAsterisk !== \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface::MISSING) {
            @\trigger_error('The "use_asterisk" configuration option is deprecated in league/commonmark 1.6 and will be replaced with "commonmark > use_asterisk" in 2.0', \E_USER_DEPRECATED);
        } else {
            $deprecatedUseAsterisk = \true;
        }
        if ($environment->getConfig('commonmark/use_asterisk', $deprecatedUseAsterisk)) {
            $environment->addDelimiterProcessor(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\EmphasisDelimiterProcessor('*'));
        }
        $deprecatedUseUnderscore = $environment->getConfig('use_underscore', \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface::MISSING);
        if ($deprecatedUseUnderscore !== \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ConfigurationInterface::MISSING) {
            @\trigger_error('The "use_underscore" configuration option is deprecated in league/commonmark 1.6 and will be replaced with "commonmark > use_underscore" in 2.0', \E_USER_DEPRECATED);
        } else {
            $deprecatedUseUnderscore = \true;
        }
        if ($environment->getConfig('commonmark/use_underscore', $deprecatedUseUnderscore)) {
            $environment->addDelimiterProcessor(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\EmphasisDelimiterProcessor('_'));
        }
    }
}
