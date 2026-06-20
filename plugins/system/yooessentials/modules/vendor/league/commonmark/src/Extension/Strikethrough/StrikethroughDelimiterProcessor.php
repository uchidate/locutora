<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com> and uAfrica.com (http://uafrica.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Strikethrough;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\DelimiterInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractStringContainer;
final class StrikethroughDelimiterProcessor implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface
{
    public function getOpeningCharacter() : string
    {
        return '~';
    }
    public function getClosingCharacter() : string
    {
        return '~';
    }
    public function getMinLength() : int
    {
        return 2;
    }
    public function getDelimiterUse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\DelimiterInterface $opener, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\DelimiterInterface $closer) : int
    {
        $min = \min($opener->getLength(), $closer->getLength());
        return $min >= 2 ? $min : 0;
    }
    public function process(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractStringContainer $opener, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractStringContainer $closer, int $delimiterUse)
    {
        $strikethrough = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Strikethrough\Strikethrough();
        $tmp = $opener->next();
        while ($tmp !== null && $tmp !== $closer) {
            $next = $tmp->next();
            $strikethrough->appendChild($tmp);
            $tmp = $next;
        }
        $opener->insertAfter($strikethrough);
    }
}
