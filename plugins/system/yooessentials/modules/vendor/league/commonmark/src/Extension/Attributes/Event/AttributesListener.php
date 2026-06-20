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
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Event;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\FencedCode;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\Attributes;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\AttributesInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Util\AttributesHelper;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node;
final class AttributesListener
{
    private const DIRECTION_PREFIX = 'prefix';
    private const DIRECTION_SUFFIX = 'suffix';
    public function processDocument(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Event\DocumentParsedEvent $event) : void
    {
        $walker = $event->getDocument()->walker();
        while ($event = $walker->next()) {
            $node = $event->getNode();
            if (!$node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\AttributesInline && ($event->isEntering() || !$node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\Attributes)) {
                continue;
            }
            [$target, $direction] = self::findTargetAndDirection($node);
            if ($target instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock || $target instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline) {
                $parent = $target->parent();
                if ($parent instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem && $parent->parent() instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock && $parent->parent()->isTight()) {
                    $target = $parent;
                }
                if ($direction === self::DIRECTION_SUFFIX) {
                    $attributes = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Util\AttributesHelper::mergeAttributes($target, $node->getAttributes());
                } else {
                    $attributes = \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Util\AttributesHelper::mergeAttributes($node->getAttributes(), $target);
                }
                $target->data['attributes'] = $attributes;
            }
            if ($node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock && $node->endsWithBlankLine() && $node->next() && $node->previous()) {
                $previous = $node->previous();
                if ($previous instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock) {
                    $previous->setLastLineBlank(\true);
                }
            }
            $node->detach();
        }
    }
    /**
     * @param Node $node
     *
     * @return array<Node|string|null>
     */
    private static function findTargetAndDirection(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node $node) : array
    {
        $target = null;
        $direction = null;
        $previous = $next = $node;
        while (\true) {
            $previous = self::getPrevious($previous);
            $next = self::getNext($next);
            if ($previous === null && $next === null) {
                if (!$node->parent() instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\FencedCode) {
                    $target = $node->parent();
                    $direction = self::DIRECTION_SUFFIX;
                }
                break;
            }
            if ($node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\AttributesInline && ($previous === null || $previous instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline && $node->isBlock())) {
                continue;
            }
            if ($previous !== null && !self::isAttributesNode($previous)) {
                $target = $previous;
                $direction = self::DIRECTION_SUFFIX;
                break;
            }
            if ($next !== null && !self::isAttributesNode($next)) {
                $target = $next;
                $direction = self::DIRECTION_PREFIX;
                break;
            }
        }
        return [$target, $direction];
    }
    private static function getPrevious(?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node $node = null) : ?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node
    {
        $previous = $node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node ? $node->previous() : null;
        if ($previous instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock && $previous->endsWithBlankLine()) {
            $previous = null;
        }
        return $previous;
    }
    private static function getNext(?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node $node = null) : ?\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node
    {
        $next = $node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node ? $node->next() : null;
        if ($node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock && $node->endsWithBlankLine()) {
            $next = null;
        }
        return $next;
    }
    private static function isAttributesNode(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Node\Node $node) : bool
    {
        return $node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\Attributes || $node instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Attributes\Node\AttributesInline;
    }
}
