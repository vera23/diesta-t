<?php
/**
 * @module		com_slider
 * @script		slider.php
 * @author-name	surinder
 * @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * Slider Component Controller
 */
class SliderController extends JControllerLegacy
{
	protected $default_view = 'home';
}
