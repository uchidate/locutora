<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access;

use YOOtheme\Container;

class RuleLoader
{
    public function __invoke(Container $container, array $configs)
    {
        $container->extend(Access::class, static function (Access $access, $app) use ($configs) {
            foreach ($configs as $classes) {
                foreach ($classes as $class) {
                    $access->addRule($class);
                }
            }
        });
    }
}
