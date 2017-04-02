<?php
/**
* @version		$Id: sliders.php 2017-03-26 16:51:19 surinder $
* @package		Slider
* @subpackage	Controllers
* @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
* @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 *  Sliders Controller class for Slider Component
 */
class SliderControllerSliders extends JControllerAdmin{
	 
	public function __construct($config = array ()){
		parent::__construct($config);
		JRequest::setVar('view', 'Sliders');
	}
	
	/**
	 * Proxy for getModel.
	 * @since   1.6
	 */
	public function getModel($name = 'Slider', $prefix = 'SliderModel', $config = array('ignore_request' => true)){
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax(){
		// Get the input
		$pks = $this->input->post->get('cid', array(), 'array');
		$order = $this->input->post->get('order', array(), 'array');

		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return){
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
}

