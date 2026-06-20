<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use function YOOtheme\app;
use YOOtheme\Builder;
use YOOtheme\Config as Yooconfig;
use YOOtheme\Http\Request;
use YOOtheme\Path;
use ZOOlanders\YOOessentials\Config\ConfigController;
use ZOOlanders\YOOessentials\Config\ConfigEncrypter;
use ZOOlanders\YOOessentials\Config\ConfigListener;
use ZOOlanders\YOOessentials\Config\ConfigUpdater;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;

return [

    'config' => [
        'yooessentials' => [
            'version' => '1.9.3',
            'build' => '0125.1555'
        ]
    ],

    'routes' => [

        ['post', ConfigController::CONFIG_SAVE_URL, ConfigController::class . '@save'],
        ['post', ConfigController::CONFIG_IMPORT_URL, ConfigController::class . '@import'],
        ['get', CoreController::GET_CHANGELOG_URL, CoreController::class . '@getChangelog'],
        ['get', CoreController::DOWNLOAD_DEBUG_DATA_URL, CoreController::class . '@downloadDebugData', ['allowed' => true]],

    ],

    'events' => [

        // TODO: in the next update, YOO will remove the loading from this event and move it to the request construction, so we can remove this
        'app.request' => [
            ConfigListener::class => ['loadConfigFromRequest', -10]
        ],

        'customizer.init' => [
            CoreListener::class => ['initCustomizer', 10],
            ConfigListener::class => ['initCustomizer', -90],
        ],

        'config.save' => [
            ConfigListener::class => 'cleanYooConfig',
        ],

        'metadata.load' => [
            CoreListener::class => ['loadMetadata', -10],
        ],

        'yooessentials.info' => [
            ConsoleLogger::class => ['info', -10],
        ],

        'yooessentials.error' => [
            ConsoleLogger::class => ['error', -10],
        ],

        'yooessentials.config.load' => [
            ConfigListener::class => ['loadConfig', 80],
        ]

    ],

    'extend' => [

        Builder::class => function (Builder $builder, $app) {
            $update = app(UpdateTransform::class);
            $builder->addTransform('preload', $update);
        },

        // This will be the remaining piece of code
        Request::class => function (Request $request, $app) {
            $requestConfig = ConfigListener::fromRequest($request);

            /** @var Config $config */
            $config = $app(Config::class);
            if ($requestConfig !== null) {
                $config->add($requestConfig);
            }
        }

    ],

    'loaders' => [
        'yooessentials-bootstrap' => new BootstrapsLoader()
    ],

    'services' => [

        Config::class => '',

        UpdateTransform::class => function (Yooconfig $yooconfig) {
            return new UpdateTransform($yooconfig('yooessentials.version'));
        },

        ConfigEncrypter::class => function (Yooconfig $yooconfig) {
            return new \YOOtheme\Encryption\Encrypter($yooconfig->get('app.secret'));
        },

        CacheInterface::class => function () {
            return new FilesystemAdapter('yooessentials', 0, Path::resolve('~theme/cache/'));
        },

        ConfigUpdater::class => function (Yooconfig $yooconfig) {
            $updater = new ConfigUpdater($yooconfig->get('yooessentials.version'));
            $updater->addGlobals(require __DIR__ . '/updates.php');

            return $updater;
        }

    ],

];
