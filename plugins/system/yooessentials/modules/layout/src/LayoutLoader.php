<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Layout;

use YOOtheme\Container;

class LayoutLoader
{
    public function __invoke(Container $container, array $configs)
    {
        $container->extend(LayoutManager::class, static function (LayoutManager $manager, $app) use ($configs) {
            foreach ($configs as $classFiles) {
                foreach ($classFiles as $className => $configs) {
                    foreach ((array) $configs as $config) {
                        try {
                            $data = $app->config->loadFile($config);
                            $manager->addAction($data['name'], $className, $data);
                        } catch (\RuntimeException $e) {
                            if (class_exists($config)) {
                                $actionClass = $app($config);
                                if ($actionClass instanceof Action) {
                                    $manager->addAction($actionClass->name(), $config, $actionClass->getConfig());
                                }
                            }
                        }
                    }
                }
            }
        });
    }
}
