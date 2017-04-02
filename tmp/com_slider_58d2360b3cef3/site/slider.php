<?php
/**
 * @package    slider
 * @subpackage Base
 * @author      {@link }
 * @author     Created on 22-Mar-2017
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


//-- Get an instance of the controller with the prefix 'slider'
$controller = JControllerLegacy::getInstance('slider');

//-- Execute the 'task' from the Request
$controller->execute(JFactory::getApplication()->input->get('task'));

//-- Redirect if set by the controller
$controller->redirect();
