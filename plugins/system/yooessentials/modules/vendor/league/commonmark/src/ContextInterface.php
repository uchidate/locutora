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
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceParser;
interface ContextInterface
{
    /**
     * @return Document
     */
    public function getDocument() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document;
    /**
     * @return AbstractBlock|null
     */
    public function getTip() : ?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
    /**
     * @param AbstractBlock|null $block
     *
     * @return void
     */
    public function setTip(?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block);
    /**
     * @return int
     */
    public function getLineNumber() : int;
    /**
     * @return string
     */
    public function getLine() : string;
    /**
     * Finalize and close any unmatched blocks
     *
     * @return UnmatchedBlockCloser
     */
    public function getBlockCloser() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\UnmatchedBlockCloser;
    /**
     * @return AbstractBlock
     */
    public function getContainer() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
    /**
     * @param AbstractBlock $container
     *
     * @return void
     */
    public function setContainer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $container);
    /**
     * @param AbstractBlock $block
     *
     * @return void
     */
    public function addBlock(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block);
    /**
     * @param AbstractBlock $replacement
     *
     * @return void
     */
    public function replaceContainerBlock(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $replacement);
    /**
     * @return bool
     */
    public function getBlocksParsed() : bool;
    /**
     * @param bool $bool
     *
     * @return $this
     */
    public function setBlocksParsed(bool $bool);
    /**
     * @return ReferenceParser
     */
    public function getReferenceParser() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceParser;
}
