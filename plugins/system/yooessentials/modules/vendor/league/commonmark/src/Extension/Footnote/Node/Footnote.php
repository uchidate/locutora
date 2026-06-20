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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceInterface;
/**
 * @method children() AbstractBlock[]
 */
final class Footnote extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock
{
    /**
     * @var FootnoteBackref[]
     */
    private $backrefs = [];
    /**
     * @var ReferenceInterface
     */
    private $reference;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceInterface $reference)
    {
        $this->reference = $reference;
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
        return \false;
    }
    public function getReference() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceInterface
    {
        return $this->reference;
    }
    public function addBackref(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Footnote\Node\FootnoteBackref $backref) : self
    {
        $this->backrefs[] = $backref;
        return $this;
    }
    /**
     * @return FootnoteBackref[]
     */
    public function getBackrefs() : array
    {
        return $this->backrefs;
    }
}
