<?php

defined('_JEXEC') || die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;

class plgInstallerZoolanders extends CMSPlugin
{
    public function onInstallerBeforePackageDownload(&$url, &$headers)
    {
        $uri = Uri::getInstance($url);
        $host = $uri->getHost();

        // it's not us
        if (!in_array($host, ['zoolanders.com', 'static.zoolanders.com', 'www.zoolanders.com'])) {
            return;
        }

        // we already have a dlid
        if (trim($uri->getVar('dlid'))) {
            return;
        }

        $dlid = trim($this->params->get('download_id'));

        if (empty($dlid)) {

            // load default and current language
            $jlang = JFactory::getLanguage();
            $jlang->load('plg_installer_zoolanders', JPATH_ADMINISTRATOR, 'en-GB', true);
            $jlang->load('plg_installer_zoolanders', JPATH_ADMINISTRATOR, null, true);

            // warn about missing api key
            JFactory::getApplication()->enqueueMessage(JText::_('PLG_INSTALLER_ZOOLANDERS_DOWNLOAD_ID_WARNING'), 'notice');

        } else {

            $uri->setVar('dlid', $dlid);

            // joomla enforces a check, the url must end in .zip
            $uri->setVar('ext', '.zip');

            $url = $uri->toString();

        }

    }
}
