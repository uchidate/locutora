<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Element\Markdown;

use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\AbstractBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Renderer\BlockRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\ElementRendererInterface;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableRenderer as CoreTableRenderer;

final class TableRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        $block->data['attributes'] = ['class' => 'uk-table'];

        return (new CoreTableRenderer())->render($block, $htmlRenderer, $inTightList);
    }
}
