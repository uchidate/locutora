<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Element\Markdown;

use function YOOtheme\app;
use YOOtheme\File;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Block\Element\ListBlock;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\CommonMarkConverter;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Environment;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\Table;
use ZOOlanders\YOOessentials\Vendor\League\CommonMark\Extension\Table\TableExtension;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\ItemInterface;

return [

    'transforms' => [

        'render' => function ($node) {
            /** @var CacheInterface|FilesystemAdapter $cache */
            $cache = app(CacheInterface::class);

            $mdconfig = [
                'heading_remove' => $node->props['heading_remove'] ?? false,
                'heading_starting_level' => $node->props['heading_starting_level'] ?? false
            ];

            $content = '';
            $ctime = filectime(__FILE__);

            // if content as source
            if ($md = $node->props['content']) {
                $cacheKey = sprintf('%s-%s.html', $node->id, hash('crc32b', json_encode([$md, $mdconfig, $ctime])));

                $content = $cache->get($cacheKey, function (ItemInterface $item) use ($md, $mdconfig) {
                    $item->expiresAfter(0);

                    try {
                        $environment = Environment::createCommonMarkEnvironment();

                        $environment
                            ->addExtension(new HeadingExtension())
                            ->addExtension(new TableExtension())
                            ->addBlockRenderer(Table::class, new TableRenderer())
                            ->addBlockRenderer(ListBlock::class, new ListBlockRenderer());

                        $converter = new CommonMarkConverter($mdconfig, $environment);

                        return $converter->convertToHtml($md);
                    } catch (\Exception $e) {
                        if (app()->config->get('app.isCustomizer')) {
                            return 'Error Processing Markdown: ' . $e->getMessage();
                        }
                    }
                });
            }

            /**
             * if file as source
             * @deprecated since 1.1 as ytp 2.3 includes a file source
             * */
            if ($file = $node->props['file'] ?? null and File::get($file)) {
                $md = File::getContents($file);
                $cached = sprintf('%s-%s.html', $node->id, hash('crc32b', json_encode([$file, $mdconfig])));

                $content = $cache->get($cached, function (ItemInterface $item) use ($md, $mdconfig) {
                    // init md converter
                    $environment = Environment::createCommonMarkEnvironment();
                    $environment->addExtension(new HeadingExtension());
                    $converter = new CommonMarkConverter($mdconfig, $environment);

                    return $converter->convertToHtml($md);
                });
            }

            // we set the plachoder here as in element.json would mess up the logic
            $placeholder = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.';

            $node->content = $content or $placeholder;

            // Don't render element if content fields is empty
            return (bool) $node->content;
        }

    ]

];
