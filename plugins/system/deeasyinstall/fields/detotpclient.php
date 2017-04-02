<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.DeEasyInstall
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;
JFormHelper::loadFieldClass('radio');

/**
 * Form Field class for the Joomla Platform.
 * Supports a multi line area for entry of plain text
 *
 * @link   http://www.w3.org/TR/html-markup/textarea.html#textarea
 * @since  11.1
 */
class JFormFieldDetotpClient extends JFormFieldRadio
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'detotpclient';

	function getInput(){

		$totpFieldName = (string)$this->element['totpfield'];
		if (!$totpFieldName) {
			$totpFieldName = 'totpkey';
		}
		$secretKey = $this->form->getValue($totpFieldName, $this->group);
		if(!$secretKey){
			return "Please Enable this plugin to get interface options.";
		}

		static $done;

		if ($done === null){
			$done = array();
		}
		$id = $this->id;
		if ( !$this->disabled && !in_array($id, $done)){
			$document = JFactory::getDocument();
			$document
				->addScriptDeclaration('
				jQuery(document).ready(function($) {
					$("#'.$id.' label").on("click", function(){
						var $label = $(this);
		        		var $input = $("#" + $label.attr("for"));
						var cls = $input.val();
						$("#'.$id.'_tab .tab-pane").removeClass("active");
						$("#'.$id.'_tab .tab-pane."+cls).addClass("active");
					})
				});'
			);
			$done[] = $id;
		}
		$input = parent::getInput();
		
		$url = $this->getTOTPUrl($secretKey);
		$active1 = "active";
		$active2 = "";
		if($this->value == "devx-in"){
			$active1 = "";
			$active2 = "active";
		}
		$input .= '<div id="'.$id.'_tab" class="tab-content">'.
					'<div class="tab-pane googleapp '.$active1.'">'.
						'<div style="margin:5px 0px">'.
						'<div class="btn-group">'.
							'<a class="btn" target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en">'.JText::_('PLG_SYSTEM_DEEASYINSTALL_DOWNLOAD_FOR_ANDROID').'</a> '.
							'<a class="btn" target="_blank" href="https://itunes.apple.com/in/app/google-authenticator/id388497605">'.JText::_('PLG_SYSTEM_DEEASYINSTALL_DOWNLOAD_FOR_IOS').'</a>'.
						'</div>'.
						'<div style="padding:5px 0px 0px;">'.JText::_('PLG_SYSTEM_DEEASYINSTALL_APPMSG').'</div>'.
						'</div>'.
						'<img src="'.$url.'" width="200" />'.
						//'<div style="padding:5px 0px 0px;">'.JText::sprintf('PLG_SYSTEM_DEEASYINSTALL_WEBMSG', $secretKey).'</div>'.
					'</div>'.
					'<div class="tab-pane devx-in '.$active2.'"><p style="padding:10px 0px;">'.JText::sprintf('PLG_SYSTEM_DEEASYINSTALL_WEBMSG', $secretKey).'</p></div>'.
				'</div>';
		return $input;
	}

	/**
	 * Returns a QR code URL for easy setup of TOTP apps like Google Authenticator
	 *
	 * @param   string  $user      User
	 * @param   string  $hostname  Hostname
	 * @param   string  $secret    Secret string
	 *
	 * @return  string
	 */
	public function getTOTPUrl($secret, $user="", $hostname="")
	{

		if(!$hostname)
			$hostname = $_SERVER['HTTP_HOST'];
		if(!$user)
			$user = "DeEasyInstall";//JFactory::getUser()->get('name');

		$user 		= preg_replace('/[^a-zA-Z0-9_]/', "-", $user);
		$issuer 	= JFactory::getConfig()->get('sitename');
		$url 		= sprintf("otpauth://totp/%s:%s@%s?secret=%s&issuer=%s", $issuer, $user, $hostname, $secret, $issuer);
		$encoder 	= "https://chart.googleapis.com/chart?chs=200x200&chld=Q|1&cht=qr&chl=";
		$encoderURL = $encoder . urlencode($url);

		return $encoderURL;
	}

	function getOptions(){
		$fieldname 	= preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname);
		$options 	= array();
		$checked 	= false;
		$selected 	= false;
		$tmp = array(
			'value'    => "googleapp",
			'text'     => JText::_('PLG_SYSTEM_DEEASYINSTALL_GOOGLEAUTHAPP'),
			'class'    => "",
			'selected' => ($checked || $selected),
			'checked'  => ($checked || $selected)
		);

		// Add the option object to the result set.
		$options[] = (object) $tmp;

		$tmp = array(
			'value'    => "devx-in",
			'text'     => JText::_('PLG_SYSTEM_DEEASYINSTALL_DEVX_COM'),
			'class'    => "",
			'selected' => ($checked || $selected),
			'checked'  => ($checked || $selected)
		);

		// Add the option object to the result set.
		$options[] = (object) $tmp;

		return $options;
	}
}
