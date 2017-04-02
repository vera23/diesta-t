<?php
/**
* @package     Joomla.Plugin
* @subpackage  System.DeEasyInstall
*
* @copyright   Copyright (C) 2015 - 2017 developerextensions. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE
*/

defined('JPATH_BASE') or die;
// Create a new JRegistry object
JLoader::import('joomla.registry.registry');
if(!class_exists('JLogLoggerCallback') && class_exists('JLoggerCallback')){
	class JLogLoggerCallback extends JLoggerCallback{

	}
}
/**
* System plugin to install extensions from remote site.
*
* @package     Joomla.Plugin
* @subpackage  System.DeEasyInstall
* @since       2.5
*/
class PlgSystemDeEasyInstall extends JPlugin {

	private $secretKeyName = 'totpkey';
	protected $autoloadLanguage = true;
	public $logs = array();
	private $error = "";
	private $pluginVersion = 302;

	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An optional associative array of configuration settings.
	 *                             Recognized key values include 'name', 'group', 'params', 'language'
	 *                             (this list is not meant to be comprehensive).
	 *
	 * @since   11.1
	 */
	public function __construct(&$subject, $config = array()){
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function setError($error){
		$this->error = $error;
	}
	public function getError(){
		return $this->error ? $this->error : JText::_('PLG_SYSTEM_DEEASYINSTALL_PLEASETRYAGAIN');
	}

	/**
	 * Prepare form and add my field.
	 *
	 * @param   JForm  $form  The form to be altered.
	 * @param   mixed  $data  The associated data for the form.
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function onContentPrepareForm($form, $data){
		$app    = JFactory::getApplication();
		$option = $app->input->get('option');
 		//var_dump($data);
		if($option == "com_plugins" && $data->type == "plugin" && $data->folder == "system" && $data->element == "deeasyinstall"){
			if(!$data->params[$this->secretKeyName]){
				$data->params[$this->secretKeyName] = self::createSecretKey();
				//load table record and save initial 'Secret key'
				$table = JTable::getInstance('extension');
				$table->load($data->extension_id);
				$params 		= json_decode($table->params);
				$params->totpkey= $data->params[$this->secretKeyName];
				$table->params 	= json_encode($params);
				$table->store();
			}
			$app->setUserState('com_plugins.deeasyinstall.totp', $data->params[$this->secretKeyName]);
		}
	}

	public function onExtensionBeforeSave($context, $table, $isNew){
		if($context=="com_plugins.plugin" && $table->type == "plugin" && $table->folder == "system" && $table->element=='deeasyinstall'){
			$app 		= JFactory::getApplication();
			$key 		= $app->getUserState('com_plugins.deeasyinstall.totp', '');
			$app->setUserState('com_plugins.deeasyinstall.totp', '');
			$input 		= $app->input;
			$params 	= new JRegistry;
			$params->loadString($table->params);
			if(!$key || $input->get("jform_params_totpkey_refresh")=="1"){
				$key  	= self::createSecretKey();
				$MSG 	= 'PLG_SYSTEM_DEEASYINSTALL_NEWKEYCREATEDWEB';
				if($params->get('totpkeyclient') == 'googleapp'){
					$MSG = 'PLG_SYSTEM_DEEASYINSTALL_NEWKEYCREATEDAPP';
				}
				
				$app->enqueueMessage(JText::sprintf('PLG_SYSTEM_DEEASYINSTALL_NEWKEYCREATED', $key));
				$app->enqueueMessage(JText::sprintf($MSG, $key), "warning");
			}
			
			$params->set($this->secretKeyName, $key);
			$table->set("params", $params->toString());
		}
		return true;
	}

	public static function createSecretKey(){
		$totp = new DEEncryptTotp();
		return $totp->generateSecret();
	}

	private static function getPluginRecord(){
		$db = JFactory::getDbo();
		$db->setQuery("SELECT * FROM #__extensions WHERE enabled='1' AND type='plugin' AND folder='system' AND element='deeasyinstall'");
		return $db->loadObject();
	}

	private static function getPluginEditLink(){
		$row = self::getPluginRecord();
		if(!$row)
			return JUri::root().'/administrator/index.php?option=com_plugins&view=plugins&filter_search=de+easy+install';

		return JUri::root().'/administrator/index.php?option=com_plugins&view=plugin&layout=edit&extension_id='.$row->extension_id;
	}

	private function checkAuthCode($code){
		$totp = new DEEncryptTotp();
		$result = $this->getSecretKey();
		if(!$result || !$result['totpkey'])
			return false;
		if(!$totp->checkCode($result['totpkey'], $code)){
			$this->setError(JText::_('PLG_SYSTEM_DEEASYINSTALL_AUTHCODE_INVALID'));
			return false;
		}
		return true;
	}
	private function getSecretKey(){
		$totpkeyclient 		= $this->params->get('totpkeyclient', '');
		$totpkey 			= $this->params->get('totpkey', '');
		if(!$totpkeyclient || !$totpkey){
			$this->setError(JText::_('PLG_SYSTEM_DEEASYINSTALL_TOTP_PARAMS_MISSING'));
			return false;
		}
		return array('totpkeyclient'=> $totpkeyclient, 'totpkey'=>$totpkey);
	}

	public function onAfterRoute(){
		$app = JFactory::getApplication();

		// Check that we are in the site application.
		if ($app->isAdmin() || $app->input->get('deauthcode', '', 'string')){
			JLoader::discover('De', __DIR__.'/libs' );
		}
		return true;
	}

	/**
	* Method to catch the onAfterDispatch event.
	*
	* This is where we setup the click-through content highlighting for.
	* The highlighting is done with JavaScript so we just
	* need to check a few parameters and the JHtml behavior will do the rest.
	*
	* @return  boolean  True on success
	*
	* @since   2.5
	*/

	public function onAfterDispatch(){
		$app = JFactory::getApplication();

		// Check that we are in the site application.
		if ($app->isAdmin()){
			return true;
		}

		$result 			= new stdClass();
		$result->success 	= false;
		$result->message	= '';

		// Set the variables
		$input 					= $app->input;
		$deeasyinstallver 		= $input->get('deeasyinstallver', 0);
		$dejsonpcallback		= $input->get('dejsonpcallback');
		$loadDEAuthCodeForm 	= $input->get('loadDEAuthCodeForm', '');
		if(!$deeasyinstallver)
			return true;

		$stateData = false;
		$extension = false;
		if($loadDEAuthCodeForm){
			$state = $app->getUserState('com_plugins.deeasyinstall.'.$loadDEAuthCodeForm, '');
			if($state && is_array($state)){
				$stateData 			= $state;
				$deeasyinstallver 	= $stateData['deeasyinstallver'];
				$extension 			= $stateData['extension'];
			}else{
				echo '<div class="de-easy-install-msg">'.JText::_('PLG_SYSTEM_DEEASYINSTALL_PLEASETRYAGAIN').'</div>';
				$app->close();
			}
		}else{
			$extension 		= $input->get('installfromurl', '', 'string');
		}

		if(!$extension)
			return true;

		if($deeasyinstallver != $this->pluginVersion){
			$result->message = JText::_('PLG_SYSTEM_DEEASYINSTALL_UPDATE_PLUGIN');
			$result->invalidVersion = $this->pluginVersion;
		}


		$urlfilter 			= explode(',', $this->params->get('urlfilter', 'developerextensions.com'));
		$urlData 			= parse_url($extension);
		if(!in_array($urlData['host'], $urlfilter)){
			$result->message = JText::sprintf(JText::_('PLG_SYSTEM_DEEASYINSTALL_DOMAIN_FILTER_ISSUE'), $urlData['host'] );
			$result->invalidHost = $urlData['host'];
		}

		if($result->invalidVersion || $result->invalidHost){
			echo $dejsonpcallback.'('.json_encode($result).');';
			$app->close();
		}

		$deauthcode				= $input->get('deauthcode', '', 'string');
		$authCodeMsg 			= "";
		if($deauthcode){
			if($this->checkAuthCode($deauthcode)){
				if($stateData){
					$app->setUserState('com_plugins.deeasyinstall.'.$loadDEAuthCodeForm, '');
				}
				try {
					$r = $this->installExtension($extension);
					$result->message 	= $r['message'];
					$result->success 	= $r['success'];
				}catch(Exception $e){
					$result->message	= $e->getMessage();
				}
				ob_get_clean();
				//echo '##deeasyinstallstart##'.json_encode($result).'##deeasyinstallend##';
				if($loadDEAuthCodeForm){
					echo '<div class="de-easy-install-msg">'.$result->message.'</div>';
				}else{
					echo $dejsonpcallback.'('.json_encode($result).');';
				}
				$app->close();
				return true;
			}else{
				$authCodeMsg = $this->getError();
			}
		}
		if($loadDEAuthCodeForm){
			$data = array('link'=>self::getPluginEditLink(), 'deeasyinstallver'=>$deeasyinstallver, 'msg'=>JText::_('PLG_SYSTEM_DEEASYINSTALL_TOTP_REQUIRED'), 'authCodeMsg'=>$authCodeMsg);
			echo $this->getRenderer('detotpform')->render($data);
			$app->close();
		}else if($authCodeMsg){
			$result->message = JText::_('PLG_SYSTEM_DEEASYINSTALL_AUTHCODE_INVALID_WEB');
			echo $dejsonpcallback.'('.json_encode($result).');';
			$app->close();
		}

		$totpkeyclient 		= $this->params->get('totpkeyclient', '');
		$totpkey 			= $this->params->get('totpkey', '');
		if(!$totpkeyclient || !$totpkey || ($totpkeyclient!='googleapp' && $totpkeyclient!='devx-in')){
			$result->message = JText::_('PLG_SYSTEM_DEEASYINSTALL_TOTP_PARAMS_MISSING');
		}else{
			$result->requiredTOTP 	= time().'.'.rand()*1000;
			$result->message 		= JText::_('PLG_SYSTEM_DEEASYINSTALL_TOTP_REQUIRED');
			$app->setUserState('com_plugins.deeasyinstall.'.$result->requiredTOTP, array(
				'extension'=>$extension,
				'deeasyinstallver'=>$deeasyinstallver
			));
		}

		echo $dejsonpcallback.'('.json_encode($result).');';
		$app->close();
	}

	/**
	 * Get the renderer
	 *
	 * @param   string  $layoutId  Id to load
	 *
	 * @return  JLayout
	 *
	 * @since   3.5
	 */
	private function getRenderer($layoutId = 'detotpform'){
		return new JLayoutFile($layoutId, __DIR__.'/layout');
	}

	public function log($entry){
		$this->logs[] = $entry->message;
	}

	private function installExtension($extension){
		$result 	= array('success'=>true);
		$app 		= JFactory::getApplication();
		$package 	= $this->_getPackageFromUrl($extension);
		if(!$package){
			$result['message'] = $this->getError();
			$result['success'] = false;
			return $result;
		}

		JLog::addLogger(
			array(
				// Sets file name
				'logger'=>'Callback',
				'callback' => array($this, 'log'),
				//'text_file' => 'deeasyInstall.errors.php'
				),
			// Sets messages of all log levels to be sent to the file
			JLog::ALL,
			// The log category/categories which should be recorded in this file
			// In this case, it's just the one category from our extension, still
			// we need to put it inside an array
			array('jerror')
		);
		// Get an installer instance
		$installer = JInstaller::getInstance();

		// Install the package
		if (!$installer->install($package['dir'])){
			// There was an error installing the package
			$result['message'] = JText::sprintf('There was an error installing the component (%s)', strtoupper($package['type']) ).'<br>'.implode('<br>', $installer->getErrors()).$installer->message;
			if(count($this->logs)){
				$result['message'] .= '<hr /><b>Errors:</b><br />'.implode("<br />", $this->logs).'<hr />';
			}
			$result['success'] = false;
		}else{
			$data = json_decode($installer->generateManifestCache());
			$name = JText::_($data->name);
			$version = $data->version;
			// Package installed sucessfully
			$result['message'] = JText::sprintf('Package installed sucessfully (%s, %s)', $name, $data->version );
		}
		return $result;	
	}

	/**
	* Install an extension from a URL
	*
	* @return  Package details or false on failure
	*
	* @since   1.5
	*/
	private function _getPackageFromUrl($url){
		// Did you give us a URL?
		if (!$url){
			$this->setError(JText::_('PLG_SYSTEM_DEEASYINSTALL_ENTER_A_URL'));
			return false;
		}

		// Download the package at the URL given
		$p_file = JInstallerHelper::downloadPackage($url);

		// Was the package downloaded?
		if (!$p_file){
			$this->setError(JText::_('PLG_SYSTEM_DEEASYINSTALL_INVALID_URL'));
			return false;
		}

		$config   = JFactory::getConfig();
		$tmp_dest = $config->get('tmp_path');

		// Unpack the downloaded package file
		$package = JInstallerHelper::unpack($tmp_dest . '/' . $p_file);

		return $package;
	}
}
