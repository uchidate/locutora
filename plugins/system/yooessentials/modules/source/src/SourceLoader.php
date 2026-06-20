<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source;

use YOOtheme\Container;

class SourceLoader
{
    public function __invoke(Container $container, array $configs)
    {
        $container->extend(SourceService::class, static function (SourceService $service) use ($container, $configs) {
            foreach ($configs as $config) {
                foreach ($config as $type => $class) {
                    $service->addSourceType($type, $class);
                }
            }
        });
    }
}
