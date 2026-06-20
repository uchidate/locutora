<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext;
final class TaskListItemMarkerParser implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Parser\InlineParserInterface
{
    public function getCharacters() : array
    {
        return ['['];
    }
    public function parse(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\InlineParserContext $inlineContext) : bool
    {
        $container = $inlineContext->getContainer();
        // Checkbox must come at the beginning of the first paragraph of the list item
        if ($container->hasChildren() || !($container instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\Paragraph && $container->parent() && $container->parent() instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListItem)) {
            return \false;
        }
        $cursor = $inlineContext->getCursor();
        $oldState = $cursor->saveState();
        $m = $cursor->match('/\\[[ xX]\\]/');
        if ($m === null) {
            return \false;
        }
        if ($cursor->getNextNonSpaceCharacter() === null) {
            $cursor->restoreState($oldState);
            return \false;
        }
        $isChecked = $m !== '[ ]';
        $container->appendChild(new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList\TaskListItemMarker($isChecked));
        return \true;
    }
}
