<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Request;

return [

    'events' => [

        'source.init' => [
            // Higher than 50 to allow loading always, and not being cached by ytp
            SourceListener::class => ['initSource', 61]
        ]

    ],

];
