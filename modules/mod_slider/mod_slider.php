<?php
/**
 * @copyright	Copyright © 2017 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	http://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
// Include assets
$doc->addStyleSheet(JURI::root()."modules/mod_slider/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_slider/assets/js/script.js");
// $width 			= $params->get("width");


	$db = JFactory::getDBO();
	$db->setQuery("SELECT * FROM uomsr_sl_slider where published=1 ORDER By ordering");
	$objects = $db->loadAssocList();

require JModuleHelper::getLayoutPath('mod_slider', $params->get('layout', 'default'));