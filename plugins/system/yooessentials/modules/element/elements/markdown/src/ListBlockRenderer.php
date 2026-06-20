<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Element\Markdown;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\BlockRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\ListBlockRenderer as CoreListBlockRenderer;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;

final class ListBlockRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!$block instanceof ListBlock) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        $listData = $block->getListData();

        $class = ['uk-list'];

        if ($listData->type === ListBlock::TYPE_BULLET && $listData->bulletChar === '-') {
            array_push($class, 'uk-list-hyphen');
        }

        if ($listData->type === ListBlock::TYPE_BULLET && $listData->bulletChar === '*') {
            array_push($class, 'uk-list-disc');
        }

        if ($listData->type === ListBlock::TYPE_BULLET && $listData->bulletChar === '+') {
            array_push($class, 'uk-list-square');
        }

        if ($listData->type === ListBlock::TYPE_ORDERED) {
            array_push($class, 'uk-list-decimal');
        }

        $block->data['attributes'] = ['class' => implode(' ', $class)];

        return (new CoreListBlockRenderer())->render($block, $htmlRenderer, $inTightList);
    }
}
