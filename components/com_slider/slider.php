<?php
/**
 * @module		com_slider
 * @author-name	surinder
 * @package		com_slider
 * @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');

// DS has removed from J 3.0
if(!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables'.DS);

// Get an instance of the controller prefixed by Slider
$controller = JControllerLegacy::getInstance('Slider');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
