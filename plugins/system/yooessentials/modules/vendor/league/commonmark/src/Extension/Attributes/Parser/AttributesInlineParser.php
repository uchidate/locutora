<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) 2015 Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Parser;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\AttributesInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Util\AttributesHelper;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext;
final class AttributesInlineParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCharacters() : array
    {
        return ['{'];
    }
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineContext) : bool
    {
        $cursor = $inlineContext->getCursor();
        $char = (string) $cursor->peek(-1);
        $attributes = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Util\AttributesHelper::parseAttributes($cursor);
        if ($attributes === []) {
            return \false;
        }
        if ($char === ' ' && ($previousInline = $inlineContext->getContainer()->lastChild()) instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text) {
            $previousInline->setContent(\rtrim($previousInline->getContent(), ' '));
        }
        if ($char === '') {
            $cursor->advanceToNextNonSpaceOrNewline();
        }
        $node = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\AttributesInline($attributes, $char === ' ' || $char === '');
        $inlineContext->getContainer()->appendChild($node);
        return \true;
    }
}
