<?php
/**
* @package RSForm! Pro
* @copyright (C) 2016 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class plgSystemRsfpadvancedformfieldsInstallerScript
{
	protected static $minJoomla = '3.7.0';
	protected static $minComponent = '3.0.0';

	public function preflight($type, $parent)
    {
		if ($type == 'uninstall')
		{
			return true;
		}
		
		try
        {
			$jversion = new JVersion();
			if (!$jversion->isCompatible(static::$minJoomla))
			{
				throw new Exception(sprintf('Please upgrade to at least Joomla! %s before continuing!', static::$minJoomla));
			}

			if (!file_exists(JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php'))
			{
				throw new Exception('Please install the RSForm! Pro component before continuing.');
			}

			if (!file_exists(JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/assets.php') || !file_exists(JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/version.php'))
			{
				throw new Exception(sprintf('Please upgrade RSForm! Pro to at least version %s before continuing!', static::$minComponent));
			}

			// Check version matches
			require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/version.php';

			if (!class_exists('RSFormProVersion') || version_compare((string) new RSFormProVersion, static::$minComponent, '<'))
			{
				throw new Exception(sprintf('Please upgrade RSForm! Pro to at least version %s before continuing!', static::$minComponent));
			}
			
			// Update? Run our SQL file
			if ($type == 'update')
			{
				$this->runSQL($parent->getParent()->getPath('source'), 'install');
			}
		}
		catch (Exception $e)
        {
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
			return false;
		}
		
		return true;
	}

	protected function runSQL($source, $file)
	{
		$db = JFactory::getDbo();
		$sqlfile = $source . '/sql/mysql/' . $file . '.sql';

		if (file_exists($sqlfile))
		{
			$buffer = file_get_contents($sqlfile);
			if ($buffer !== false)
			{
				$queries = $db->splitSql($buffer);
				foreach ($queries as $query)
				{
					$query = trim($query);
					if ($query != '')
					{
						$db->setQuery($query)->execute();
					}
				}
			}
		}
	}

	public function postflight($type, $parent)
	{
		if ($type == 'install')
		{
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update($db->qn('#__extensions'))
					->set($db->qn('enabled') . ' = ' . $db->q(1))
					->where($db->qn('element') . ' = ' . $db->q('rsfpadvancedformfields'))
					->where($db->qn('type') . '=' . $db->q('plugin'))
					->where($db->qn('folder') . '=' . $db->q('system'));
			$db->setQuery($query);
			$db->execute();
		}
	}

    public function install($parent) {
        $this->copyFiles($parent);
    }

    public function update($parent) {
        $this->copyFiles($parent);
    }

    protected function copyFiles($parent) {
        $app = JFactory::getApplication();
        $src = $parent->getParent()->getPath('source').'/admin';
        $dest = JPATH_ADMINISTRATOR.'/components/com_rsform';

        if (!JFolder::copy($src, $dest, '', true))
        {
            $app->enqueueMessage('Could not copy to '.str_replace(JPATH_SITE, '', $dest).', please make sure destination is writable!', 'error');
        }
    }
}