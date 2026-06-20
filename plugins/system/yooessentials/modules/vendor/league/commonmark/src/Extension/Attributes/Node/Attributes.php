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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor;
final class Attributes extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock
{
    /** @var array<string, mixed> */
    private $attributes;
    /**
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }
    /**
     * @return array<string, mixed>
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }
    public function canContain(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock $block) : bool
    {
        return \false;
    }
    public function isCode() : bool
    {
        return \false;
    }
    public function matchesNextLine(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor) : bool
    {
        $this->setLastLineBlank($cursor->isBlank());
        return \false;
    }
    public function shouldLastLineBeBlank(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Cursor $cursor, int $currentLineNumber) : bool
    {
        return \false;
    }
}
