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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\Attributes;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Util\AttributesHelper;
final class AttributesBlockParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Parser\BlockParserInterface
{
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        $state = $cursor->saveState();
        $attributes = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Util\AttributesHelper::parseAttributes($cursor);
        if ($attributes === []) {
            return \false;
        }
        if ($cursor->getNextNonSpaceCharacter() !== null) {
            $cursor->restoreState($state);
            return \false;
        }
        $context->addBlock(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\Attributes($attributes));
        $context->setBlocksParsed(\true);
        return \true;
    }
}
