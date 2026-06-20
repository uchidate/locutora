<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document;
/**
 * Event dispatched when the document has been fully parsed
 */
final class DocumentParsedEvent extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\AbstractEvent
{
    /** @var Document */
    private $document;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document)
    {
        $this->document = $document;
    }
    public function getDocument() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document
    {
        return $this->document;
    }
}
