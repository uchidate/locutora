<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source;

use function YOOtheme\app;
use YOOtheme\Config as Yooconfig;
use YOOtheme\Metadata;
use YOOtheme\Path;

class SourceListener
{
    public static function initCustomizer(Yooconfig $yooconfig, Metadata $metadata, SourceService $sourceService)
    {
        $providers = [];

        foreach ($sourceService->sourceTypes() as $type => $class) {
            $provider = app($class)->metadata();
            $providers[$provider->name] = (array) $provider;
        }

        $yooconfig->addFile('customizer', Path::get('../config/customizer.json'));
        $yooconfig->set('customizer.yooessentials.source_providers', $providers);
        $metadata->set('script:yooessentials-source', ['src' => '~yooessentials_url/modules/source/assets/customizer.min.js', 'defer' => true]);
    }

    public static function initSources(SourceService $sourceService, $source)
    {
        $sourceService->registerSources($source);
    }
}
