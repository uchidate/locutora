<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources;

use ZOOlanders\YOOessentials\Config\ConfigUpdater;
use ZOOlanders\YOOessentials\UpdateTransform;

return [

    'extend' => [

        ConfigUpdater::class => function (ConfigUpdater $updater) {
            $updater->addGlobals(require __DIR__ . '/updates.php');
        },

        UpdateTransform::class => function (UpdateTransform $update) {
            $update->addGlobals(require __DIR__ . '/updates.php');
        },

    ],

    'yooessentials-bootstrap' => [
        __DIR__ . '/src/Csv/bootstrap.php',
        __DIR__ . '/src/Database/bootstrap.php',
        __DIR__ . '/src/Facebook/bootstrap.php',
        __DIR__ . '/src/GoogleSheet/bootstrap.php',
        __DIR__ . '/src/GoogleMyBusiness/bootstrap.php',
        __DIR__ . '/src/Instagram/bootstrap.php',
        __DIR__ . '/src/TikTok/bootstrap.php',
        __DIR__ . '/src/Twitter/bootstrap.php',
        __DIR__ . '/src/CloudflareStream/bootstrap.php',
        __DIR__ . '/src/YouTube/bootstrap.php',
        __DIR__ . '/src/Request/bootstrap.php',
        __DIR__ . '/src/Vimeo/bootstrap.php',
        __DIR__ . '/src/Rss/bootstrap.php',
    ],

];
