<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_slider
 * @author-name	surinder
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_slider')){
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// DS has removed from J 3.0
if(!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

//include Helper
require_once(JPATH_COMPONENT.'/helpers/slider.php');

// Execute the task.
$controller	= JControllerLegacy::getInstance('Slider');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
