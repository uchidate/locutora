<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents;
interface TableOfContentsGeneratorInterface
{
    public function generate(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document) : ?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents;
}
// Trigger autoload without causing a deprecated error
\class_exists(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents::class);
