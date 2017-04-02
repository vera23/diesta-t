<?php
/**
 * @version		$Id:controller.php 2017-03-26 surinder $
 * @author	   	Surinder Singh
 * @package    	Slider
 * @subpackage 	Controllers
 * @copyright  	Copyright (C) 2017, Surinder Singh. All rights reserved.
 * @license 	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Slider Standard Controller
 *
 * @package 	Slider   
 * @subpackage 	Controllers
 */
class SliderController extends JControllerLegacy{	
	
	/**
	 * Method to display a view.
	 *
	 * @param   boolean			If true, the view output will be cached
	 * @param   array  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController		This object to support chaining.
	 * @since   1.5
	 */
	function display($cachable = false, $urlparams = array()){	
		JRequest::setVar('view', JRequest::getVar('view', 'home'));
		parent::display($cachable, $urlparams);

		return $this;
	}

}// class
  
?>