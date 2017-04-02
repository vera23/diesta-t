<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_slider
 *
 * @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
 * @license 	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

/**
 * View to edit a slider.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_slider
 * @since       1.5
 */
class SliderViewSlider extends JViewLegacy{

	protected $form;

	protected $item;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null){
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if(count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar(){
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$canDo		= SliderHelper::getActions();

		JToolbarHelper::title($isNew ? JText::_('COM_SLIDER_MANAGER_SLIDER_NEW') : JText::_('COM_SLIDER_MANAGER_SLIDER_EDIT'), 'Slider.png');

		// If not checked out, can save the item.
		if(!$checkedOut &&  ($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_slider', 'core.create')) > 0)){
			JToolbarHelper::apply('slider.apply');
			JToolbarHelper::save('slider.save');

			if($canDo->get('core.create')){
				JToolbarHelper::save2new('slider.save2new');
			}
		}

		// If an existing item, can save to a copy.
		if(!$isNew && $canDo->get('core.create')){
			JToolbarHelper::save2copy('slider.save2copy');
		}

		if(empty($this->item->id)){
			JToolbarHelper::cancel('slider.cancel');
		}else{
			JToolbarHelper::cancel('slider.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolbarHelper::divider();
		//JToolbarHelper::help('JHELP_COMPONENTS_SLIDER_SLIDER_EDIT');
		JToolbarHelper::help('sliders', true, 'index.php?option=com_slider&view=help&key=slider&tmpl=component');
	}
}
