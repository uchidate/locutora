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
/**
 * Maintains the current state of the Markdown parser engine
 */
class Context implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface
{
    /**
     * @var EnvironmentInterface
     */
    protected $environment;
    /**
     * @var Document
     */
    protected $doc;
    /**
     * @var AbstractBlock|null
     */
    protected $tip;
    /**
     * @var AbstractBlock
     */
    protected $container;
    /**
     * @var int
     */
    protected $lineNumber;
    /**
     * @var string
     */
    protected $line;
    /**
     * @var UnmatchedBlockCloser
     */
    protected $blockCloser;
    /**
     * @var bool
     */
    protected $blocksParsed = \false;
    /**
     * @var ReferenceParser
     */
    protected $referenceParser;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\EnvironmentInterface $environment)
    {
        $this->doc = $document;
        $this->tip = $this->doc;
        $this->container = $this->doc;
        $this->environment = $environment;
        $this->referenceParser = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceParser($document->getReferenceMap());
        $this->blockCloser = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\UnmatchedBlockCloser($this);
    }
    /**
     * @param string $line
     *
     * @return void
     */
    public function setNextLine(string $line)
    {
        ++$this->lineNumber;
        $this->line = $line;
    }
    public function getDocument() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document
    {
        return $this->doc;
    }
    public function getTip() : ?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock
    {
        return $this->tip;
    }
    /**
     * @param AbstractBlock|null $block
     *
     * @return $this
     */
    public function setTip(?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block)
    {
        $this->tip = $block;
        return $this;
    }
    public function getLineNumber() : int
    {
        return $this->lineNumber;
    }
    public function getLine() : string
    {
        return $this->line;
    }
    public function getBlockCloser() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\UnmatchedBlockCloser
    {
        return $this->blockCloser;
    }
    public function getContainer() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock
    {
        return $this->container;
    }
    /**
     * @param AbstractBlock $container
     *
     * @return $this
     */
    public function setContainer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $container)
    {
        $this->container = $container;
        return $this;
    }
    public function addBlock(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block)
    {
        $this->blockCloser->closeUnmatchedBlocks();
        $block->setStartLine($this->lineNumber);
        while ($this->tip !== null && !$this->tip->canContain($block)) {
            $this->tip->finalize($this, $this->lineNumber);
        }
        // This should always be true
        if ($this->tip !== null) {
            $this->tip->appendChild($block);
        }
        $this->tip = $block;
        $this->container = $block;
    }
    public function replaceContainerBlock(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $replacement)
    {
        $this->blockCloser->closeUnmatchedBlocks();
        $replacement->setStartLine($this->container->getStartLine());
        $this->container->replaceWith($replacement);
        if ($this->tip === $this->container) {
            $this->tip = $replacement;
        }
        $this->container = $replacement;
    }
    public function getBlocksParsed() : bool
    {
        return $this->blocksParsed;
    }
    /**
     * @param bool $bool
     *
     * @return $this
     */
    public function setBlocksParsed(bool $bool)
    {
        $this->blocksParsed = $bool;
        return $this;
    }
    public function getReferenceParser() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Reference\ReferenceParser
    {
        return $this->referenceParser;
    }
}
