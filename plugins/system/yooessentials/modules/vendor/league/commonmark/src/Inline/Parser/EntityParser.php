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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\Html5EntityDecoder;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper;
final class EntityParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface
{
    public function getCharacters() : array
    {
        return ['&'];
    }
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineContext) : bool
    {
        if ($m = $inlineContext->getCursor()->match('/^' . \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\RegexHelper::PARTIAL_ENTITY . '/i')) {
            $inlineContext->getContainer()->appendChild(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Text(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\Html5EntityDecoder::decode($m)));
            return \true;
        }
        return \false;
    }
}
