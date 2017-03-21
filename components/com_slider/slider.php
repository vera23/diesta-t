<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Slider
 * @author     Miroshnichenko Vera Mikhailovna <veramir10@gmail.com>
 * @copyright  2017 Miroshnichenko Vera Mikhailovna
 * @license    GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Slider', JPATH_COMPONENT);
JLoader::register('SliderController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Slider');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
