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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Newline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper;
final class EscapableParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface
{
    public function getCharacters() : array
    {
        return ['\\'];
    }
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineContext) : bool
    {
        $cursor = $inlineContext->getCursor();
        $nextChar = $cursor->peek();
        if ($nextChar === "\n") {
            $cursor->advanceBy(2);
            $inlineContext->getContainer()->appendChild(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Newline(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Newline::HARDBREAK));
            return \true;
        } elseif ($nextChar !== null && \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::isEscapable($nextChar)) {
            $cursor->advanceBy(2);
            $inlineContext->getContainer()->appendChild(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text($nextChar));
            return \true;
        }
        $cursor->advanceBy(1);
        $inlineContext->getContainer()->appendChild(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text('\\'));
        return \true;
    }
}
