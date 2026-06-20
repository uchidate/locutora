<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;
use YOOtheme\Application;
use YOOtheme\Database;
use YOOtheme\Path;

class plgSystemYooessentials extends CMSPlugin
{
    public function onAfterInitialise()
    {
        if (!class_exists(Application::class, false)) {
            return;
        }

        $checksum = $this->validateChecksum();

        if (!empty($checksum)) {
            throw new \Exception('YOOessentials plugin has been prevented from executing due to corrupted installation or altered files.');
        }

        include_once(__DIR__ . '/modules/autoload.php');

        $app = Application::getInstance();
        $db = $app(Database::class);

        $root = __DIR__;
        $rootUrl = Uri::root(true);

        // set alias
        Path::setAlias('~yooessentials', $root);
        Path::setAlias('~yooessentials_url', $rootUrl . '/plugins/system/yooessentials');

        // fetch config
        $config = $db->fetchObject('SELECT custom_data FROM #__extensions WHERE element=:element AND folder=:folder', ['element' => 'yooessentials', 'folder' => 'system']);
        $config = json_decode($config->custom_data, true) ?? [];

        $modules = ['core', 'api', 'auth', 'storage'];

        $addons = [
            'dynamic' => '',
            'form' => 'dynamic',
            'access' => 'dynamic',
            'icon' => '',
            'source' => '',
            'layout' => '',
            'element' => '',
            'legacy' => '',
        ];

        foreach ($addons as $addon => $dep) {
            // check addon dependency
            if ($dep && !in_array($dep, $modules)) {
                continue;
            }

            // load addons only if state not explicitly false
            if ($config[$addon]['state'] ?? true) {
                $modules = array_merge($modules, [$addon]);
            }
        }

        foreach ($modules as $module) {
            $app->load('~yooessentials/modules/{' . $module . '{,-joomla}}/bootstrap.php');
        }
    }

    private function validateChecksum(): array
    {
        $path = JPATH_ROOT . '/plugins/system/yooessentials';
        $checksum = "$path/checksums.txt";
        $checksumPass = "$path/checksums_ok";

        if (file_exists($checksumPass)) {
            return [];
        }

        $file = file_exists($checksum) ? fopen($checksum, 'r') : null;

        // if for some reason the file is not here, assume it's all ok
        if (!$file) {
            return [];
        }

        $log = [];
        while ($row = fgets($file)) {
            list($md5, $fileName) = explode(' ', trim($row), 2);

            $filePath = $path . '/' . trim($fileName);
            $fileMd5 = md5_file($filePath);

            if (!file_exists($filePath)) {
                $log['missing'][] = $filePath;

                continue;
            }

            if ($fileMd5 !== $md5) {
                $log['changed'][] = $filePath;
            }
        }

        if (empty($log)) {
            $file = fopen($checksumPass, 'w') or die('Unable to create file!');
            fwrite($file, 'OK');
            fclose($file);
        }

        return $log;
    }
}
