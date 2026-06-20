<?php

defined('_JEXEC') or die();

class plgInstallerZoolandersInstallerScript
{
    public function preflight($type, $parent)
    {
        if ($type !== 'update') {
            return;
        }

        $installed = (string) $this->getManifest()->version;
        $new = (string) $parent->manifest->version;

        // downgrades are not allowed
        return version_compare($new, $installed, '>=');
    }

    public function postflight($type, $parent)
    {
        if ($type === 'install') {
            $this->enableExtension();
        }

        return true;
    }

    private function enableExtension()
    {
        $db = JFactory::getDbo();

        try {

            $query = $db->getQuery(true)
                ->update('#__extensions')
                ->set($db->qn('enabled') . ' = ' . $db->q(1))
                ->where('type = ' . $db->quote('plugin'))
                ->where('folder = ' . $db->quote('installer'))
                ->where('element = ' . $db->quote('zoolanders'));

            $db->setQuery($query)->execute();

        } catch (\Exception $e) {
            return;
        }
    }

    private function getManifest ()
    {
        $db = JFactory::getDBO();

        $query = $db->getQuery(true)
            ->select('manifest_cache')
            ->from('#__extensions')
            ->where('type = ' . $db->quote('plugin'))
            ->where('folder = ' . $db->quote('installer'))
            ->where('element = ' . $db->quote('zoolanders'));

        $manifest = $db->setQuery($query)->loadObject();

        return $manifest
            ? json_decode($manifest->manifest_cache)
            : false;
    }
}
