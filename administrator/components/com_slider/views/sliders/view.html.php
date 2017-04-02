<?php
/**
* @version		$Id:Sliders.php 2017-03-26 16:51:19 surinder $
* @package		Slider
* @subpackage 	View
* @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
* @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

defined('_JEXEC') or die('Restricted access'); 

/**
 * View class for a list of slider.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_slider
 * @since       1.6
 */
class SliderViewSliders extends JViewLegacy{
	
	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 *
	 * @since   1.6
	 */
	public function display($tpl = null) {
		$this->jversion 	= new JVersion;
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		SliderHelper::addSubmenu('sliders');

		$this->addToolbar();
		
		if ($this->jversion->isCompatible('3.2')){
			$this->sidebar = JHtmlSidebar::render();
		}else{
			$this->sidebar = self::renderSidebar();
		}
		parent::display($tpl);
	}

	/*
	* Compatibility function for Joomla 3.0
	*/
	public static function renderSidebar() {
		// Collect display data
		$data                 = new stdClass;
		$data->list           = JHtmlSidebar::getEntries();
		$data->filters        = JHtmlSidebar::getFilters();
		$data->action         = JHtmlSidebar::getAction();
		$data->displayMenu    = count($data->list);
		$data->displayFilters = count($data->filters);
		$data->hide           = JFactory::getApplication()->input->getBool('hidemainmenu');

		// Create a layout object and ask it to render the sidebar
		$layout      = new JLayoutFile('joomla.sidebars.submenu', JPATH_COMPONENT . '/layouts');
		$sidebarHtml = $layout->render($data);

		return $sidebarHtml;
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
		$canDo 	= SliderHelper::getActions('');
		$this->canDo = $canDo;
		$user 	= JFactory::getUser();
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');

		JToolbarHelper::title(JText::_('COM_SLIDER_MANAGER_SLIDERS'), 'Slider.png');
		
		if($canDo->get('core.create')){
			JToolbarHelper::addNew('slider.add');
		}
				
		if(($canDo->get('core.edit'))){
			JToolbarHelper::editList('slider.edit');
		}
		if($canDo->get('core.edit.state')){
			if($this->state->get('filter.state') != 2){
				JToolbarHelper::publish('sliders.publish', 'JTOOLBAR_PUBLISH', true);
				JToolbarHelper::unpublish('sliders.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			}

			if($this->state->get('filter.state') != -1){
				if($this->state->get('filter.state') != 2){
					JToolbarHelper::archiveList('sliders.archive');
				}elseif ($this->state->get('filter.state') == 2){
					JToolbarHelper::unarchiveList('sliders.publish');
				}
			}
		}
		if($canDo->get('core.edit.state')){
			JToolbarHelper::checkin('sliders.checkin');
		}
		if($this->state->get('filter.state') == -2 && $canDo->get('core.delete')){
			JToolbarHelper::deleteList('', 'sliders.delete', 'JTOOLBAR_EMPTY_TRASH');
		}elseif ($canDo->get('core.edit.state')){
			JToolbarHelper::trash('sliders.trash');
		}

		if ($canDo->get('core.admin')){
			JToolbarHelper::preferences('com_slider');
		}
		JToolbarHelper::help('sliders', true, 'index.php?option=com_slider&view=help&key=sliders&tmpl=component');

		JHtmlSidebar::setAction('index.php?option=com_slider&view=sliders');
		
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_state',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
		);

	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields(){
		return array(
		
			'a.id' => JText::_('COM_SLIDER_HEADING_ID'),
			'ordering' => JText::_('COM_SLIDER_HEADING_ORDERING'),
			'a.checked_out_time' => JText::_('COM_SLIDER_HEADING_CHECKED_OUT_TIME'),
			'a.checked_out' => JText::_('COM_SLIDER_HEADING_CHECKED_OUT'),
			'a.published' => JText::_('COM_SLIDER_HEADING_PUBLISHED'),
			'a.new_price' => JText::_('COM_SLIDER_HEADING_NEW_PRICE'),
			'a.old_price' => JText::_('COM_SLIDER_HEADING_OLD_PRICE'),
			'a.image' => JText::_('COM_SLIDER_HEADING_IMAGE'),
			'a.description' => JText::_('COM_SLIDER_HEADING_DESCRIPTION')
		);
	}
}
