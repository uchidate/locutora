<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth;

return [

    'events' => [

        'customizer.init' => [
            AuthListener::class => [['initCustomizer', -10], ['loadAuths', -10]],
        ],

        'yooessentials.config.save' => [
            AuthListener::class => 'saveAuths'
        ],

    ],

    'services' => [

        AuthManager::class => '',

    ],

    'loaders' => [
        'yooessentials-auth-drivers' => new AuthDriverLoader(),
    ],

    'yooessentials-bootstrap' => [
        __DIR__ . '/../auth-drivers/bootstrap.php'
    ],

];
