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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ThematicBreak;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper;
final class ThematicBreakParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface
{
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        if ($cursor->isIndented()) {
            return \false;
        }
        $match = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::matchAt(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::REGEX_THEMATIC_BREAK, $cursor->getLine(), $cursor->getNextNonSpacePosition());
        if ($match === null) {
            return \false;
        }
        // Advance to the end of the string, consuming the entire line (of the thematic break)
        $cursor->advanceToEnd();
        $context->addBlock(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ThematicBreak());
        $context->setBlocksParsed(\true);
        return \true;
    }
}
