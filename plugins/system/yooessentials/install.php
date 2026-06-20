<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Installer\Installer;
use Joomla\CMS\Installer\InstallerHelper;

defined('_JEXEC') or die;

class plgSystemYooessentialsInstallerScript
{
    const minPHP = '7.2';
    const minYTP = '2.3.32';
    const minJoomla = '3.9';

    public function preflight($type, $parent)
    {
        $app = Factory::getApplication();
        $msg = null;

        if (!in_array($type, ['install', 'update'])) {
            return;
        }

        // check minimum PHP version
        if (!version_compare(PHP_VERSION, self::minPHP, 'ge')) {
            $msg = sprintf('You need PHP %s or later to install this extension.', self::minPHP);
        }

        // check minimum Joomla version
        if (!version_compare(JVERSION, self::minJoomla, 'ge')) {
            $msg = sprintf('You need Joomla! %s or later to install this extension.', self::minJoomla);
        }

        // check minimum yootheme pro version
        $yoo = simplexml_load_file(JPATH_ROOT . '/templates/yootheme/templateDetails.xml');
        if (!$yoo or !version_compare((string) $yoo->version, self::minYTP, 'ge')) {
            $msg = sprintf('You need YOOtheme Pro %s or later to install this extension.', self::minYTP);
        }

        if ($msg) {
            $app->enqueueMessage($msg, 'warning');

            return false;
        }

        $this->relocateIcons();

        // avoid downgrades
        if ($this->isPremiumInstalled() and !$this->isPremiumBeingInstalled($parent)) {
            $app->enqueueMessage('Downgrade prevented. Uninstall the Premium plugin before trying to downgrade to the free version.', 'warning');

            return false;
        }

        // by deleting the update servers we keep them up to date as well as solving
        // the potential issue of free update server overtaking the premium one
        if ($type === 'update') {
            $this->deleteUpdateServers($parent);
        }

        // delete modules to avoid potential update and downgrade issues
        if (Folder::exists($path = JPATH_ROOT . '/plugins/system/yooessentials/modules')) {
            Folder::delete($path);
        }
    }

    public function postflight($type, $parent)
    {
        if (!in_array($type, ['install', 'update'])) {
            return;
        }

        $this->installInstallerPackage($parent);
        $this->clearCache();

        if ($type === 'install') {
            $this->enableExtension();
        }

        return true;
    }

    private function relocateIcons()
    {
        $src = JPATH_ROOT . '/plugins/system/yooessentials/modules/icons/icons';
        $dst = JPATH_ROOT . '/media/yooessentials/icons';

        if (Folder::exists($src)) {
            Folder::copy($src, $dst, '', true);
            Folder::delete($src);
        }
    }

    protected function deleteUpdateServers($parent)
    {
        $db = Factory::getDBO();

        $ids = $db->setQuery(
            'SELECT `update_site_id` FROM `#__update_sites_extensions`' .
            " WHERE `extension_id` = (SELECT `extension_id` FROM `#__extensions` WHERE `type` = 'plugin' AND `folder` = 'system' AND `element` = 'yooessentials')"
        )->loadObjectList();

        foreach ($ids as $id) {
            $db->setQuery(
                "DELETE FROM `#__update_sites_extensions` WHERE `update_site_id` = $id->update_site_id"
            )->execute();

            $db->setQuery(
                "DELETE FROM `#__update_sites` WHERE `update_site_id` = $id->update_site_id"
            )->execute();
        }
    }

    protected function isPremiumBeingInstalled($parent)
    {
        $src = $parent->getParent()->getPath('source');

        return Folder::exists("$src/modules/access");
    }

    protected function isPremiumInstalled()
    {
        return Folder::exists(JPATH_ROOT . '/plugins/system/yooessentials/modules/access');
    }

    // silently install the zoolanders installer
    private function installInstallerPackage($parent)
    {
        $src = $parent->getParent()->getPath('source');

        try {
            if (File::exists("$src/installer.zip")) {
                $package = InstallerHelper::unpack("$src/installer.zip")['dir'];

                $tmpInstaller = new Installer;
                $tmpInstaller->install($package);
            }
        } catch (\Exception $e) {
            return;
        }
    }

    private function enableExtension()
    {
        $this->enableOrDisableExtension(true);
    }

    private function enableOrDisableExtension(bool $enable)
    {
        $db = Factory::getDbo();

        try {
            $query = $db->getQuery(true)
                ->update('#__extensions')
                ->set($db->qn('enabled') . ' = ' . $db->q($enable ? 1 : 0))
                ->where('type = ' . $db->quote('plugin'))
                ->where('folder = ' . $db->quote('system'))
                ->where('element = ' . $db->quote('yooessentials'));

            $db->setQuery($query)->execute();
        } catch (\Exception $e) {
            return;
        }
    }

    private static function clearCache($files = null)
    {
        $files = $files ?: self::getCacheFiles();

        foreach ($files as $file) {
            if (is_iterable($file)) {
                self::clearCache($file);
            } elseif ($file->isFile()) {
                unlink($file->getRealPath());
            } elseif ($file->isDir()) {
                rmdir($file->getRealPath());
            }
        }
    }

    private static function getCacheFiles()
    {
        $files = [
            new SplFileInfo(JPATH_ROOT . '/templates/yootheme/cache/schema-1.gql')
        ];

        $cachePath = JPATH_ROOT . '/templates/yootheme/cache/yooessentials';

        if (file_exists($cachePath)) {
            $iterator = new \RecursiveDirectoryIterator($cachePath, \FilesystemIterator::SKIP_DOTS);
            $files[] = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);
        }

        return $files;
    }
}
