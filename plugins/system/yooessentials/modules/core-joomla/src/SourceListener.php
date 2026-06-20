<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Joomla;

use YOOtheme\Builder\Source;
use YOOtheme\GraphQL\Type\Definition\IntType;
use ZOOlanders\YOOessentials\Feature;

class SourceListener
{
    /**
     * @param Source $source
     */
    public static function extendCoreTypes($source)
    {
        if (Feature::cannotUse(Feature::SOURCE_EXTEND_TYPE)) {
            return;
        }

        foreach (['User', 'Article', 'Category', 'Contact'] as $name) {
            $source->objectType($name, [
                'fields' => [
                    'id' => [
                        'name' => 'id',
                        'type' => IntType::int(),
                        'metadata' => [
                            'label' => 'ID'
                        ]
                    ]
                ]
            ]);
        }
    }
}
