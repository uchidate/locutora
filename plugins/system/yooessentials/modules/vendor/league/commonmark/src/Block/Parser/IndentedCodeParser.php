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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\IndentedCode;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
final class IndentedCodeParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface
{
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        if (!$cursor->isIndented()) {
            return \false;
        }
        if ($context->getTip() instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph) {
            return \false;
        }
        if ($cursor->isBlank()) {
            return \false;
        }
        $cursor->advanceBy(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor::INDENT_LEVEL, \true);
        $context->addBlock(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\IndentedCode());
        return \true;
    }
}
