<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth;

use function YOOtheme\app;
use YOOtheme\Container;

class AuthDriverLoader
{
    public function __invoke(Container $container, array $configs)
    {
        $container->extend(AuthManager::class, static function (AuthManager $manager) use ($container, $configs) {
            foreach ($configs as $classFiles) {
                foreach ($classFiles as $className => $drivers) {
                    foreach ((array) $drivers as $driver) {
                        $data = app()->config->loadFile($driver);
                        $manager->addDriver($data['name'], new $className($data));
                    }
                }
            }
        });
    }
}
