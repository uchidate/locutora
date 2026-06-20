<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace YOOtheme;

use YOOtheme\Builder\ElementTransform;

return [

    'transforms' => [

        'render' => function ($node, array $params) {

            /** @var Config $config */
            $config = app(Config::class);

            /** @var View $view */
            $view = app(View::class);

            /** @var Metadata $metadata */
            $metadata = app(Metadata::class);

            /** @var ElementTransform $transform */
            $transform = new ElementTransform($view);

            $metadata->set('script:yooessentials-social-sharing-network', ['src' => '~yooessentials_url/modules/element/elements/social_sharing_item/assets/asset.js', 'defer' => true]);

            $networks = [
                'twitter' => 'https://twitter.com/intent/tweet?text=%s',
                'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=%s',
                'whatsapp' => 'https://api.whatsapp.com/send?text=%s',
                'telegram' => 'https://t.me/share/url?url=%s&text=%s',
                'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=%s',
                'pinterest' => 'http://pinterest.com/pin/create/button/?url=%s',
                'xing' => 'https://www.xing.com/spi/shares/new?url=%s',
                'custom' => $node->props['custom_link'] ?? ''
            ];

            $url = urlencode($config->get('req')['href']);
            $text = $node->props['text'] ?? '';
            $network = $node->props['link'];

            $node->props['link'] = sprintf($networks[$network] ?? '', $url, $text);

            if (empty($node->props['icon']) && $network === 'telegram') {
                $metadata->set('script:yooessentials-social-sharing-telegram', sprintf('UIkit.icon.add(%s)', json_encode([
                    'yooessentials-social-sharing-telegram' => File::getContents(__dir__ . '/assets/icon-telegram.svg')
                ])));

                $node->props['icon'] = 'yooessentials-social-sharing-telegram';
            }

            if ($node->props['link_target'] === 'popup') {
                $node->popup = json_encode([
                    'width' => $node->props['link_target_width'] ?: 600,
                    'height' => $node->props['link_target_height'] ?: 600
                ]);
            }

            // set attributes
            $node->attrs += [
                'id' => $node->props['id'] ?? null,
                'class' => !empty($node->props['class']) ? [$node->props['class']] : [],
            ];

            // apply attributes transforms
            $transform->customAttributes($node);

            // Don't render element if content fields are empty
            return $node->props['link'];
        }

    ],

    'yooessentialsUpdates' => [

        '1.2.0-beta' => function ($node) {
            if (is_bool($node->props['link_target'] ?? '')) {
                $node->props['link_target'] = $node->props['link_target'] ? '_blank' : '_self';
            }
        }

    ]

];
