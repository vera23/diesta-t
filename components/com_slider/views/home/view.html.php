<?php
/**
* @version		$Id: view.html.php 2017-03-26 surinder $
* @package		Slider
* @subpackage 	Views
* @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
* @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

 
class SliderViewHome  extends JViewLegacy {

	public function display($tpl = null){
		
		$app 		= JFactory::getApplication('site');
		$document	= JFactory::getDocument();
		$uri 		= JFactory::getURI();
		$user 		= JFactory::getUser();
		$pagination	= $this->get('pagination');
		$params		= $app->getParams();				
		$menus	    = $app->getMenu();
		
		$menu		= $menus->getActive();
		
		if (is_object( $menu )) {
			$menu_params = $menus->getParams($menu->id) ;
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title', 'Home');
			}
		}
		$this->menu 		= $menu;		

		
		$this->params 		= $params;
		$this->pagination 	= $pagination;
		
		parent::display($tpl);
	}
}
?>