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
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Input\MarkdownInputInterface;
/**
 * Event dispatched when the document is about to be parsed
 */
final class DocumentPreParsedEvent extends \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\AbstractEvent
{
    /** @var Document */
    private $document;
    /** @var MarkdownInputInterface */
    private $markdown;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Input\MarkdownInputInterface $markdown)
    {
        $this->document = $document;
        $this->markdown = $markdown;
    }
    public function getDocument() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document
    {
        return $this->document;
    }
    public function getMarkdown() : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Input\MarkdownInputInterface
    {
        return $this->markdown;
    }
    public function replaceMarkdown(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Input\MarkdownInputInterface $markdownInput) : void
    {
        $this->markdown = $markdownInput;
    }
}
