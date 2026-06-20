<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Request;

class SourceListener
{
    public static function initSource($source)
    {
        $source->objectType('YooessentialsRequest', Type\RequestType::config());
        $source->objectType('YooessentialsRequestUrl', Type\RequestUrlType::config());
        $source->queryType(Type\RequestQueryType::config());
    }
}
