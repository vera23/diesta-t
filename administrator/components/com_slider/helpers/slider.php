<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_slider
 *
 * @copyright   Copyright (C) 2017, Surinder Singh. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

/**
 * Banners component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_slider
 * @since       1.6
 */
class SliderHelper {
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string	The name of the active view.
	 *
	 * @return  void
	 * @since   1.6
	 */
	public static function addSubmenu($vName){
		
		JHtmlSidebar::addEntry(JText::_('COM_SLIDER_SUBMENU_HOMES'),	'index.php?option=com_slider&view=home', ($vName == 'home')	);
		JHtmlSidebar::addEntry(JText::_('COM_SLIDER_SUBMENU_HELP'),	'index.php?option=com_slider&view=help', ($vName == 'help')	);
		JHtmlSidebar::addEntry(JText::_('COM_SLIDER_SUBMENU_SLIDERS'),	'index.php?option=com_slider&view=sliders', ($vName == 'sliders')	);		
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   integer  The category ID.
	 *
	 * @return  JObject
	 * @since   1.6
	 */
	public static function getActions($categoryId = 0, $sublevel=''){
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId))	{
			$assetName = 'com_slider';
			$level = 'component'.($sublevel?'.'.$sublevel:'');
		}else{
			$assetName = 'com_slider.category.'.(int) $categoryId;
			$level = 'category'.($sublevel?'.'.$sublevel:'');
		}

		$actions = JAccess::getActions('com_slider', $level);

		foreach ($actions as $action){
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}

	// Create the batch selector selection list.
	public static function createBatchOptionList($name, $id, $options){
		$NAME = strtoupper($name);
		$jversion = new JVersion;
		if($jversion->isCompatible('3.1.2')){
			$title = JHtml::tooltipText('COM_SLIDER_BATCH_'.$NAME.'_LABEL', 'COM_SLIDER_BATCH_'.$NAME.'_LABEL_DESC');
		}else{
			$title = '<strong>'.JText::_('COM_SLIDER_BATCH_'.$NAME.'_LABEL').'</strong><div>'.JText::_('COM_SLIDER_BATCH_'.$NAME.'_LABEL_DESC').'</div>';
		}
		$lines = array(
			'<label id="batch-'.$name.'-lbl" for="'.$id.'" class="hasTooltip" title="'.$title.'">',
			JText::_('COM_SLIDER_BATCH_'.$NAME.'_LABEL'),
			'</label>'
		);

		if (is_array($options)){
			$lines = array_merge($lines, array(
					'<select name="batch['.$name.']" id="'.$id.'">',
					'<option value="">' .  JText::_('COM_SLIDER_BATCH_'.$NAME.'_NOCHANGE') . '</option>',
					'<option value="0">' . JText::_('COM_SLIDER_BATCH_'.$NAME.'_NO') . '</option>',
					JHtml::_('select.options', $options, 'value', 'text'),
					'</select>'
				)
			);
		}else{
			$lines[] = $options;
		}

		return implode("\n", $lines);
	}

	/**
	 * @return  boolean
	 * @since   1.6
	 */
	public static function updateReset(){}
}
