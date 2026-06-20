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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ArrayCollection;
/**
 * @method children() AbstractInline[]
 */
abstract class AbstractStringContainerBlock extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\StringContainerInterface
{
    /**
     * @var ArrayCollection<int, string>
     */
    protected $strings;
    /**
     * @var string
     */
    protected $finalStringContents = '';
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->strings = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Util\ArrayCollection();
    }
    public function addLine(string $line)
    {
        $this->strings[] = $line;
    }
    public abstract function handleRemainingContents(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor);
    public function getStringContent() : string
    {
        return $this->finalStringContents;
    }
}
