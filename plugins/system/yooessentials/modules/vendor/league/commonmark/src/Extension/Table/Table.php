<?php

declare (strict_types=1);
/*
 * This is part of the league/commonmark package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractStringContainerBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\InlineContainerInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
final class Table extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractStringContainerBlock implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\InlineContainerInterface
{
    /** @var TableSection */
    private $head;
    /** @var TableSection */
    private $body;
    /** @var \Closure */
    private $parser;
    public function __construct(\Closure $parser)
    {
        parent::__construct();
        $this->appendChild($this->head = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableSection(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableSection::TYPE_HEAD));
        $this->appendChild($this->body = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableSection(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableSection::TYPE_BODY));
        $this->parser = $parser;
    }
    public function canContain(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block) : bool
    {
        return $block instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableSection;
    }
    public function isCode() : bool
    {
        return \false;
    }
    public function getHead() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableSection
    {
        return $this->head;
    }
    public function getBody() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableSection
    {
        return $this->body;
    }
    public function matchesNextLine(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        return \call_user_func($this->parser, $cursor, $this);
    }
    public function handleRemainingContents(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : void
    {
    }
}
