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

class GoogleMyBusinessMediaLocationAssociation extends AbstractObjectType implements HasSourceInterface
{
    public const TYPE_NAME = 'GoogleMyBusinessMediaLocationAssociation';

    public function name(): string
    {
        return self::TYPE_NAME;
    }

    public function config(): array
    {
        return [
            'fields' => [
                'category' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Category'
                    ]
                ],
                'priceListItemId' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Price List Item Id'
                    ]
                ],
            ],
            'metadata' => [
                'type' => true,
                'label' => 'Location Association',
            ],
        ];
    }
}
