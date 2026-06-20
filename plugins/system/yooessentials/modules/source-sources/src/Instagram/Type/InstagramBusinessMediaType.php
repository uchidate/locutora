<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\Instagram\Type;

class InstagramBusinessMediaType extends InstagramMediaType
{
    public const TYPE_NAME = 'InstagramBusinessMedia';
    public const TYPE_LABEL = 'Instagram Business Media';

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function label(): string
    {
        return self::TYPE_LABEL;
    }

    public function config(): array
    {
        $config = parent::config();

        $config['fields']['comments_count'] = [
            'type' => 'Int',
            'metadata' => [
                'label' => 'Comments Count',
            ],
        ];

        $config['fields']['like_count'] = [
            'type' => 'Int',
            'metadata' => [
                'label' => 'Like Count',
            ],
        ];

        return $config;
    }
}
