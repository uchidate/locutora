<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Legacy;

use ZOOlanders\YOOessentials\Legacy\Access\DatetimeLegacyRule;
use ZOOlanders\YOOessentials\UpdateTransform;

return [

    'extend' => [

        UpdateTransform::class => function (UpdateTransform $update) {
            $update->addGlobals(require __DIR__ . '/updates.php');
        },

    ],

    'yooessentials-access-rules' => [
        DatetimeLegacyRule::class,
    ],

    'yooessentials-bootstrap' => [
        __DIR__ . '/src/FormAction/SaveCsvLegacy/bootstrap.php',
        __DIR__ . '/src/FormAction/SaveGoogleSheetLegacy/bootstrap.php',
    ],
];
