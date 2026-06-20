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

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface;
final class TaskListItemMarkerRenderer implements \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Renderer\InlineRendererInterface
{
    /**
     * @param TaskListItemMarker       $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement|string|null
     */
    public function render(\ZOOlanders\YOOessentials\Vendor\League\CommonMark\Inline\Element\AbstractInline $inline, \ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface $htmlRenderer)
    {
        if (!$inline instanceof \ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\TaskList\TaskListItemMarker) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }
        $checkbox = new \ZOOlanders\YOOessentials\Vendor\League\CommonMark\HtmlElement('input', [], '', \true);
        if ($inline->isChecked()) {
            $checkbox->setAttribute('checked', '');
        }
        $checkbox->setAttribute('disabled', '');
        $checkbox->setAttribute('type', 'checkbox');
        return $checkbox;
    }
}
