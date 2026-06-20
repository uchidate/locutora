<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Source;

class FormQueryType
{
    public static function config(): array
    {
        return [
            'fields' => [
                'yooessentials_form_query' => [
                    'type' => FormType::TYPE_NAME,
                    'args' => [],
                    'metadata' => [
                        'label' => 'Form Submission',
                        'group' => 'Submission',
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolve',
                            'args' => []
                        ]
                    ],
                ]
            ]
        ];
    }

    public static function resolve($data)
    {
        return $data;
    }
}
