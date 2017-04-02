<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.DeEasyInstall
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Supports a multi line area for entry of plain text
 *
 * @link   http://www.w3.org/TR/html-markup/textarea.html#textarea
 * @since  11.1
 */
class JFormFieldDetotp extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'detotp';

	/**
	 * Method to get the textarea field input markup.
	 * Use the rows and columns attributes to specify the dimensions of the area.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		if(!$this->value){
			return "Please Enable this plugin to get Secret Key";
		}

		static $done;

		if ($done === null)
		{
			$done = array();
		}
		// Translate placeholder text
		$hint = $this->translateHint ? JText::_($this->hint) : $this->hint;

		// Initialize some field attributes.
		$class        = !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$disabled     = $this->disabled ? ' disabled' : '';
		$readonly     = ' readonly';
		$required     = $this->required ? ' required aria-required="true"' : '';
		$hint         = strlen($hint) ? ' placeholder="' . $hint . '"' : '';
		$autocomplete = ' autocomplete="off"';
		$autofocus    = $this->autofocus ? ' autofocus' : '';
		$spellcheck   = ' spellcheck="false"';
		$maxlength    = "";//$this->maxlength ? ' maxlength="' . $this->maxlength . '"' : '';

		// Initialize JavaScript field attributes.
		$onchange = $this->onchange ? ' onchange="' . $this->onchange . '"' : '';
		$onclick = $this->onclick ? ' onclick="' . $this->onclick . '"' : '';
		$id = $this->id ? $this->id : 'totp_'.((int)(rand()*1000));

		// Including fallback code for HTML5 non supported browsers.
		JHtml::_('jquery.framework');
		JHtml::_('script', 'system/html5fallback.js', false, true);
		// Only display the triggers once for each control.
		if ( !$disabled && !in_array($id, $done))
		{
			$document = JFactory::getDocument();
			$document
				->addScriptDeclaration(
				'jQuery(document).ready(function($) {
					$("#'.$id.'_btn").on("click", function(){
						$("#'.$id.'_refresh").val("1");
						Joomla.submitbutton("plugin.apply");
					})
				});'
			);
			$done[] = $id;
		}
		// Hide button using inline styles for readonly/disabled fields
		$btn_style = ($disabled) ? ' style="display:none;"' : '';
		$div_class = (!$disabled) ? ' class="input-append"' : '';
		

		return '<div' . $div_class . '>'
				.'<input type="hidden" name="' . $id . '_refresh" id="' . $id . '_refresh" />'
				. '<input type="text" name="' . $this->name . '" value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '" id="' . $id . '"' . $class
				. $hint . $disabled . $readonly . $onchange . $onclick . $required . $autocomplete . $autofocus . $spellcheck . $maxlength . ' />'
				. '<button type="button" class="btn" id="' . $id . '_btn"' . $btn_style . '>'.JText::_('PLG_SYSTEM_DEEASYINSTALL_CREATE_NEW_KEY').'</button>'
			. '</div>';
	}
}
