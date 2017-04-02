<?php
/**
* @package     Joomla.Plugin
* @subpackage  System.DeEasyInstall
*
* @copyright   Copyright (C) 2015 - 2017 developerextensions. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE
*/

defined('JPATH_BASE') or die;

class plgsystemdeeasyinstallInstallerScript
{
	/**
	 * Constructor
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	//public function __construct(JAdapterInstance $adapter);
 
	/**
	 * Called before any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	//public function preflight($route, JAdapterInstance $adapter);
 
	/**
	 * Called after any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	//public function postflight($route, JAdapterInstance $adapter);
 
	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function install(JAdapterInstance $adapter){
		//$source = $adapter->getParent()->getPath('source');
		//$adapter->loadLanguage($source. '/language/');
		$db = JFactory::getDbo();
		$db->setQuery("UPDATE #__extensions SET enabled='1' WHERE type='plugin' AND folder='system' AND element='deeasyinstall'");
		$db->execute();
		$db->setQuery("SELECT * FROM #__extensions WHERE enabled='1' AND type='plugin' AND folder='system' AND element='deeasyinstall'");
		$row = $db->loadObject();
		if($row){
			require 'libs/encryptbase32.php';
			require 'libs/encrypttotp.php';
			$totp 	= new DEEncryptTotp();
			$table 	= JTable::getInstance('extension');
			$table->load($row->extension_id);
			$params 		= json_decode($table->params);
			$params->totpkey= $totp->generateSecret();
			$table->params 	= json_encode($params);
			$table->store();
		}else{
			echo '<p>' . JText::_('PLG_SYSTEM_DEEASYINSTALL_OPENNSAVE_TEXT') . '</p>';
		}
		echo '<p>' . JText::_('PLG_SYSTEM_DEEASYINSTALL_AUTOENABLED_TEXT') . '</p>';
		return true;
	}
 
	/**
	 * Called on update
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	//public function update(JAdapterInstance $adapter);
 
	/**
	 * Called on uninstallation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	//public function uninstall(JAdapterInstance $adapter);
}
?>