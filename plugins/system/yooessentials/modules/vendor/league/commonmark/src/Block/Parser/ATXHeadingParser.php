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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper;
final class ATXHeadingParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface
{
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        if ($cursor->isIndented()) {
            return \false;
        }
        $match = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::matchFirst('/^#{1,6}(?:[ \\t]+|$)/', $cursor->getLine(), $cursor->getNextNonSpacePosition());
        if (!$match) {
            return \false;
        }
        $cursor->advanceToNextNonSpaceOrTab();
        $cursor->advanceBy(\strlen($match[0]));
        $level = \strlen(\trim($match[0]));
        $str = $cursor->getRemainder();
        /** @var string $str */
        $str = \preg_replace('/^[ \\t]*#+[ \\t]*$/', '', $str);
        /** @var string $str */
        $str = \preg_replace('/[ \\t]+#+[ \\t]*$/', '', $str);
        $context->addBlock(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading($level, $str));
        $context->setBlocksParsed(\true);
        return \true;
    }
}
