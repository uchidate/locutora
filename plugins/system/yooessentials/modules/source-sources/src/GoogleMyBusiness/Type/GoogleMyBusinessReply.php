<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Sources\GoogleMyBusiness\Type;

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractObjectType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;

class GoogleMyBusinessReply extends AbstractObjectType implements HasSourceInterface
{
    public const TYPE_NAME = 'GoogleMyBusinessReply';

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'comment' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Comment',
                        'filters' => ['limit']
                    ]
                ],
                'updateTime' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Updated on',
                        'filters' => ['date']
                    ]
                ],
            ],
            'metadata' => [
                'type' => true,
                'label' => 'Review Reply',
            ],
        ];
    }
}
