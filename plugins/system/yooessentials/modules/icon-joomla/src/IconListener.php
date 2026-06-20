<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Icon\Joomla;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Document\HtmlDocument;
use Joomla\Input\Input;
use ZOOlanders\YOOessentials\Icon\IconLoader;

class IconListener
{
    public static function loadIcons(CMSApplication $application, Input $input, IconLoader $loader, IconCacheHelper $cacheHelper, $context = null, $article = null, $params = [])
    {
        $icons = $loader->queued();
        $isArticle = $input->getCmd('option') === 'com_content' && !$input->getCmd('task') && $input->getCmd('id');

        if ($isArticle) {
            list($articleId) = explode(':', $input->getString('id'));
            $icons = array_merge($icons, $cacheHelper->get((int) $articleId));
        }

        // Check which icons where not rendered yet to avoid duplication
        $icons = $loader->yetToRender($icons);
        if (count($icons) <= 0) {
            return;
        }

        $document = $application->getDocument();

        if (!$document instanceof HtmlDocument) {
            return;
        }

        $iconScript = sprintf('UIkit.icon.add(%s)', json_encode($icons));
        $document->addCustomTag("<script>{$iconScript}</script>");

        $loader->addRenderedIcons($icons);
    }
}
