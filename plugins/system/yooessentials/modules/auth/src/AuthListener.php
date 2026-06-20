<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth;

use YOOtheme\Arr;
use YOOtheme\Config as Yooconfig;
use YOOtheme\Event;
use YOOtheme\Metadata;
use YOOtheme\Path;
use ZOOlanders\YOOessentials\Config;

class AuthListener
{
    public static function initCustomizer(Yooconfig $yooconfig, Metadata $metadata, AuthManager $authManager)
    {
        $yooconfig->addFile('customizer', Path::get('../config/customizer.json'));
        $yooconfig->set('customizer.yooessentials.auth_drivers', $authManager->drivers());

        $metadata->set('script:yooessentials-auth', ['src' => '~yooessentials_url/modules/auth/assets/customizer.min.js', 'defer' => true]);
    }

    public static function loadAuths(Config $config, AuthManager $authManager)
    {
        $key = AuthManager::AUTHS_CONFIG_KEY;

        try {
            $auths = $authManager->createAuths($config->get($key, []));

            $auths = array_map(function (Auth $auth) {
                return $auth->withDecryptedKeys()->toArray();
            }, $auths);

            $config->set($key, $auths);
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'auth',
                'task' => 'load-config',
                'error' => $e->getMessage()
            ]);
        }
    }

    public static function saveAuths(AuthManager $authManager, $values)
    {
        $key = AuthManager::AUTHS_CONFIG_KEY;

        try {
            $auths = $authManager->createAuths(Arr::get($values, $key, []));
            $auths = AuthManager::removeDuplicates($auths);

            $auths = array_map(function (Auth $auth) {
                return $auth->withEncryptedKeys()->toArray();
            }, $auths);

            Arr::set($values, $key, $auths);

            return $values;
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'auth',
                'task' => 'save-config',
                'error' => $e->getMessage()
            ]);

            return $values;
        }
    }
}
