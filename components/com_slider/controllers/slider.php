<?php
/**
 * @package     Slider
 * @subpackage  Controller
 *
 * @copyright   Copyright (C) 2017-03-26 16:51:19 Surinder Singh. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

/**
 * Slider controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_slider
 * @since       1.6
 */
class SliderControllerSlider extends JControllerForm {
	
	/**
	 * The URL view list variable.
	 *
	 * @var    string
	 * @since  12.2
	 */
	protected $view_list = 'sliders';

	/**
	 * The URL view item variable.
	 *
	 * @var    string
	 * @since  12.2
	 */
	protected $view_item = 'sliders';

	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_SLIDER_SLIDER';

	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowAdd($data = array()){
		// you can add your custom code here
		return parent::allowAdd($data);
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id'){
			
		// you can add your custom code here
		return parent::allowEdit($data, $key);
	}
	
	/**
	 * Method to edit an existing record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key
	 * (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if access level check and checkout passes, false otherwise.
	 *
	 * @since   12.2
	 */
	public function edit($key = null, $urlVar = null){
		$result = parent::edit($key, $urlVar);
		if(!$result){
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=sliders', false
				)
			);
		}
		return $result;
	}

	/**
	 * Method to run batch operations.
	 *
	 * @param   string  $model  The model
	 *
	 * @return  boolean  True on success.
	 *
	 * @since	2.5
	 */
	public function batch($model = null){
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model	= $this->getModel('Slider', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_slider&view=sliders' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}

}
