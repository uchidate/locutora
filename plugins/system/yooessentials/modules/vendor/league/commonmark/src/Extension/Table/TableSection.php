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
final class TableSection extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractStringContainerBlock implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\InlineContainerInterface
{
    const TYPE_HEAD = 'thead';
    const TYPE_BODY = 'tbody';
    /** @var string */
    public $type = self::TYPE_BODY;
    public function __construct(string $type = self::TYPE_BODY)
    {
        parent::__construct();
        $this->type = $type;
    }
    public function isHead() : bool
    {
        return self::TYPE_HEAD === $this->type;
    }
    public function isBody() : bool
    {
        return self::TYPE_BODY === $this->type;
    }
    public function canContain(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block) : bool
    {
        return $block instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableRow;
    }
    public function isCode() : bool
    {
        return \false;
    }
    public function matchesNextLine(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        return \false;
    }
    public function handleRemainingContents(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\ContextInterface $context, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : void
    {
    }
}
