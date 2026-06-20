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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceMap;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceMapInterface;
/**
 * @method children() AbstractBlock[]
 */
class Document extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock
{
    /** @var ReferenceMapInterface */
    protected $referenceMap;
    public function __construct(?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceMapInterface $referenceMap = null)
    {
        $this->setStartLine(1);
        $this->referenceMap = $referenceMap ?? new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceMap();
    }
    /**
     * @return ReferenceMapInterface
     */
    public function getReferenceMap() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceMapInterface
    {
        return $this->referenceMap;
    }
    public function canContain(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block) : bool
    {
        return \true;
    }
    public function isCode() : bool
    {
        return \false;
    }
    public function matchesNextLine(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        return \true;
    }
}
