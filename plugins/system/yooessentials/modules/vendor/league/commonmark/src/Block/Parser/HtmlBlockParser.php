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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\HtmlBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper;
final class HtmlBlockParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface
{
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        if ($cursor->isIndented()) {
            return \false;
        }
        if ($cursor->getNextNonSpaceCharacter() !== '<') {
            return \false;
        }
        $savedState = $cursor->saveState();
        $cursor->advanceToNextNonSpaceOrTab();
        $line = $cursor->getRemainder();
        for ($blockType = 1; $blockType <= 7; $blockType++) {
            $match = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::matchAt(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::getHtmlBlockOpenRegex($blockType), $line);
            if ($match !== null && ($blockType < 7 || !$context->getContainer() instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph)) {
                $cursor->restoreState($savedState);
                $context->addBlock(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\HtmlBlock($blockType));
                $context->setBlocksParsed(\true);
                return \true;
            }
        }
        $cursor->restoreState($savedState);
        return \false;
    }
}
