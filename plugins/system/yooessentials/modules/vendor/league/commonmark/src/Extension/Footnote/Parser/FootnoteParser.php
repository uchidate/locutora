<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) Rezo Zero / Ambroise Maupate
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Parser;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\Footnote;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\Reference;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper;
final class FootnoteParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface
{
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        if ($cursor->isIndented()) {
            return \false;
        }
        $match = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::matchFirst('/^\\[\\^([^\\n^\\]]+)\\]\\:\\s/', $cursor->getLine(), $cursor->getNextNonSpacePosition());
        if (!$match) {
            return \false;
        }
        $cursor->advanceToNextNonSpaceOrTab();
        $cursor->advanceBy(\strlen($match[0]));
        $str = $cursor->getRemainder();
        \preg_replace('/^\\[\\^([^\\n^\\]]+)\\]\\:\\s/', '', $str);
        if (\preg_match('/^\\[\\^([^\\n^\\]]+)\\]\\:\\s/', $match[0], $matches) > 0) {
            $context->addBlock($this->createFootnote($matches[1]));
            $context->setBlocksParsed(\true);
            return \true;
        }
        return \false;
    }
    private function createFootnote(string $label) : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\Footnote
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\Footnote(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\Reference($label, $label, $label));
    }
}
