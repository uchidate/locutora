<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram\Type;

use ZOOlanders\YOOessentials\Sources\Instagram\InstagramBusinessSource;

class InstagramBusinessMediaQueryType extends InstagramMediaQueryType
{
    public function config(): array
    {
        $config = parent::config();

        $config['fields'][$this->name()]['type']['listOf'] = InstagramBusinessMediaType::TYPE_NAME;
        $config['fields'][$this->name()]['extensions']['call']['func'] = __CLASS__ . '::resolve';

        return $config;
    }

    public static function getCacheKey(): string
    {
        return 'instagram-business-media';
    }

    public static function resolve($root, array $args): array
    {
        /** @var InstagramBusinessSource */
        $source = self::loadSource($args, InstagramBusinessSource::class);

        if (!$source) {
            return [];
        }

        return self::resolveFromCache($source, $args, function () use ($source, $args) {
            $limit = $args['limit'] ?? 20;

            return $source->api()->medias($source->pageId(), $limit, $args);
        });
    }
}
