<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials;

use Joomla\CMS\Factory;
use YOOtheme\Config as Yooconfig;
use ZOOlanders\YOOessentials\Config\ConfigRepositoryInterface;
use ZOOlanders\YOOessentials\Joomla\ConfigRepository;

return [

    'config' => function (Yooconfig $yooconfig) {
        $host = explode(':', $yooconfig->get('joomla.config.host', '127.0.0.1'));

        return [
            'yooessentials' => [
                'timezone' => $yooconfig->get('joomla.config.offset') ?? 'UTC',
                'language' => str_replace('_', '-', Factory::getLanguage()->get('tag')),
                'db' => [
                    'database' => $yooconfig->get('joomla.config.db'),
                    'prefix' => $yooconfig->get('joomla.config.dbprefix'),
                    'host' => array_shift($host),
                    'port' => array_shift($host) ?: 3306
                ]
            ]
        ];
    },

    'events' => [

        'theme.head' => [
            Joomla\CustomizerListener::class => ['printLogger', -999],
            ConsoleLogger::class => [['print', -999], ['alert', -999]],
        ],

        'customizer.init' => [
            Joomla\CustomizerListener::class => ['initCustomizer', 10],
        ],

        'url.resolve' => [
            Joomla\Platform::class => 'handleRoute',
        ],

        'app.request' => [
            Joomla\CsrfTokenMiddleware::class => ['@handle', 20],
        ],

        'source.init' => [
            Joomla\SourceListener::class => ['extendCoreTypes', -100],
        ],

    ],

    'extend' => [

        Form\Http\FormSubmissionRequest::class => function (Form\Http\FormSubmissionRequest $submission) {
            $submission->csrfFormToken = Joomla\Platform::printCsrfFormToken();
        },

    ],

    'services' => [

        Session::class => Joomla\Session::class,
        Unzipper::class => Joomla\Unzipper::class,
        DatabaseManager::class => Joomla\DatabaseManager::class,
        Mailer::class => [
            'class' => Joomla\Mailer::class,
            'shared' => false,
        ],
        DatabaseQuery::class => [
            'shared' => false,
            'class' => Joomla\DatabaseQuery::class,
        ],
        ConfigRepositoryInterface::class => ConfigRepository::class,

    ],

];
