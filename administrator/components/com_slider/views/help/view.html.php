<?php
/**
* @version		$Id: help.php 2017-03-26 surinder $
* @package		Slider
* @subpackage 	view
* @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
* @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
 
 
class SliderViewHelp  extends JViewLegacy {

	public function display($tpl = null){
		$app = JFactory::getApplication('');		
		SliderHelper::addSubmenu('help');

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar() {
		$app	= JFactory::getApplication('administrator');
		
		JToolbarHelper::title(JText::_('COM_SLIDER_MANAGER_HELP'), 'Help.png');
		$canDo 	= SliderHelper::getActions('');
		if ($canDo->get('core.admin')){
			JToolbarHelper::preferences('com_slider');
		}
		/*
		

		$this->canDo = $canDo;
		$user 	= JFactory::getUser();
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
	
		if($canDo->get('core.create')){
			JToolbarHelper::addNew('help.add');
		}
		
		if(($canDo->get('core.edit'))){
			JToolbarHelper::editList('help.edit');
		}

		// Add a batch button
		if ($user->authorise('core.edit')){
			JHtml::_('bootstrap.modal', 'collapseModal');
			$title = JText::_('JTOOLBAR_BATCH');
			$dhtml = "<button data-toggle=\"modal\" data-target=\"#collapseModal\" class=\"btn btn-small\">
						<i class=\"icon-checkbox-partial\" title=\"$title\"></i>
						$title</button>";
			$bar->appendButton('Custom', $dhtml, 'batch');
		}

		
		JToolbarHelper::help('help', true, 'index.php?option=com_slider&view=help&key=help&tmpl=component');
		JHtmlSidebar::setAction('index.php?option=com_slider&view=help');
		
		*/
	}	
}
?>