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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractStringContainerBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\DelimiterStack;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceMapInterface;
class InlineParserContext
{
    /** @var AbstractStringContainerBlock */
    private $container;
    /** @var ReferenceMapInterface */
    private $referenceMap;
    /** @var Cursor */
    private $cursor;
    /** @var DelimiterStack */
    private $delimiterStack;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractStringContainerBlock $container, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceMapInterface $referenceMap)
    {
        $this->referenceMap = $referenceMap;
        $this->container = $container;
        $this->cursor = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor(\trim($container->getStringContent()));
        $this->delimiterStack = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\DelimiterStack();
    }
    public function getContainer() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock
    {
        return $this->container;
    }
    public function getReferenceMap() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceMapInterface
    {
        return $this->referenceMap;
    }
    public function getCursor() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor
    {
        return $this->cursor;
    }
    public function getDelimiterStack() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Delimiter\DelimiterStack
    {
        return $this->delimiterStack;
    }
}
