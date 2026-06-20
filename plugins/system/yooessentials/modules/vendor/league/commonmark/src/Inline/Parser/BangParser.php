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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Delimiter;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext;
final class BangParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface
{
    public function getCharacters() : array
    {
        return ['!'];
    }
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineContext) : bool
    {
        $cursor = $inlineContext->getCursor();
        if ($cursor->peek() === '[') {
            $cursor->advanceBy(2);
            $node = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text('![', ['delim' => \true]);
            $inlineContext->getContainer()->appendChild($node);
            // Add entry to stack for this opener
            $delimiter = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Delimiter('!', 1, $node, \true, \false, $cursor->getPosition());
            $inlineContext->getDelimiterStack()->push($delimiter);
            return \true;
        }
        return \false;
    }
}
