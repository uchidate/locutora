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
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListData;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Exception\InvalidOptionException;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\HeadingPermalink;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer\AsIsNormalizerStrategy;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer\FlatNormalizerStrategy;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer\NormalizerStrategyInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer\RelativeNormalizerStrategy;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractStringContainer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Link;
final class TableOfContentsGenerator implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\TableOfContentsGeneratorInterface
{
    public const STYLE_BULLET = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock::TYPE_BULLET;
    public const STYLE_ORDERED = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock::TYPE_ORDERED;
    public const NORMALIZE_DISABLED = 'as-is';
    public const NORMALIZE_RELATIVE = 'relative';
    public const NORMALIZE_FLAT = 'flat';
    /** @var string */
    private $style;
    /** @var string */
    private $normalizationStrategy;
    /** @var int */
    private $minHeadingLevel;
    /** @var int */
    private $maxHeadingLevel;
    public function __construct(string $style, string $normalizationStrategy, int $minHeadingLevel, int $maxHeadingLevel)
    {
        $this->style = $style;
        $this->normalizationStrategy = $normalizationStrategy;
        $this->minHeadingLevel = $minHeadingLevel;
        $this->maxHeadingLevel = $maxHeadingLevel;
    }
    public function generate(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document) : ?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents
    {
        $toc = $this->createToc($document);
        $normalizer = $this->getNormalizer($toc);
        $firstHeading = null;
        foreach ($this->getHeadingLinks($document) as $headingLink) {
            $heading = $headingLink->parent();
            // Make sure this is actually tied to a heading
            if (!$heading instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading) {
                continue;
            }
            // Skip any headings outside the configured min/max levels
            if ($heading->getLevel() < $this->minHeadingLevel || $heading->getLevel() > $this->maxHeadingLevel) {
                continue;
            }
            // Keep track of the first heading we see - we might need this later
            $firstHeading = $firstHeading ?? $heading;
            // Keep track of the start and end lines
            $toc->setStartLine($firstHeading->getStartLine());
            $toc->setEndLine($heading->getEndLine());
            // Create the new link
            $link = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\Link('#' . $headingLink->getSlug(), self::getHeadingText($heading));
            $paragraph = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph();
            $paragraph->setStartLine($heading->getStartLine());
            $paragraph->setEndLine($heading->getEndLine());
            $paragraph->appendChild($link);
            $listItem = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem($toc->getListData());
            $listItem->setStartLine($heading->getStartLine());
            $listItem->setEndLine($heading->getEndLine());
            $listItem->appendChild($paragraph);
            // Add it to the correct place
            $normalizer->addItem($heading->getLevel(), $listItem);
        }
        // Don't add the TOC if no headings were present
        if (!$toc->hasChildren() || $firstHeading === null) {
            return null;
        }
        return $toc;
    }
    private function createToc(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document) : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents
    {
        $listData = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListData();
        if ($this->style === self::STYLE_BULLET) {
            $listData->type = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock::TYPE_BULLET;
        } elseif ($this->style === self::STYLE_ORDERED) {
            $listData->type = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock::TYPE_ORDERED;
        } else {
            throw new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Exception\InvalidOptionException(\sprintf('Invalid table of contents list style "%s"', $this->style));
        }
        $toc = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents($listData);
        $toc->setStartLine($document->getStartLine());
        $toc->setEndLine($document->getEndLine());
        return $toc;
    }
    /**
     * @param Document $document
     *
     * @return iterable<HeadingPermalink>
     */
    private function getHeadingLinks(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Document $document)
    {
        $walker = $document->walker();
        while ($event = $walker->next()) {
            if ($event->isEntering() && ($node = $event->getNode()) instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\HeadingPermalink\HeadingPermalink) {
                (yield $node);
            }
        }
    }
    private function getNormalizer(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Node\TableOfContents $toc) : \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer\NormalizerStrategyInterface
    {
        switch ($this->normalizationStrategy) {
            case self::NORMALIZE_DISABLED:
                return new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer\AsIsNormalizerStrategy($toc);
            case self::NORMALIZE_RELATIVE:
                return new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer\RelativeNormalizerStrategy($toc);
            case self::NORMALIZE_FLAT:
                return new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TableOfContents\Normalizer\FlatNormalizerStrategy($toc);
            default:
                throw new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Exception\InvalidOptionException(\sprintf('Invalid table of contents normalization strategy "%s"', $this->normalizationStrategy));
        }
    }
    /**
     * @return string
     */
    private static function getHeadingText(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Heading $heading)
    {
        $text = '';
        $walker = $heading->walker();
        while ($event = $walker->next()) {
            if ($event->isEntering() && ($child = $event->getNode()) instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractStringContainer) {
                $text .= $child->getContent();
            }
        }
        return $text;
    }
}
