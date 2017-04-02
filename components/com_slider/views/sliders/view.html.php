<?php
/**
* @version		$Id: view.html.php 2017-03-26 16:51:19 surinder $
* @package		Slider
* @subpackage 	Views
* @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
* @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Sliders HTML View class for Slider Component
 */
class SliderViewSliders  extends JViewLegacy{

	// Overwriting JView display method
	function display($tpl = null){
		
		$app 		= JFactory::getApplication('site');
		$input 		= $app->input;
		//$document	= JFactory::getDocument();
		//$uri 		= JFactory::getURI();
		//$user 	= JFactory::getUser();
		$pagination	= $this->get('pagination');
		$params		= $app->getParams();				
		$menus		= $app->getMenu();
		$id			= $input->get('id', '');
		
		$menu		= $menus->getActive();
		$title 		= '';
		if(is_object( $menu )){
			$menu_params = $menus->getParams($menu->id);
			$title = $menu_params->get('page_title');
		}

		if (!$title){
			if(!$id){
				$title = JText::_('COM_SLIDER_SLIDERS');
			}else{
				$title = JText::_('COM_SLIDER_SLIDERS_ITEM');
			}
		}

		$params->set('page_title', $title);


		// Assign data to the view
		if($id===''){			
			$this->items 		= $this->get('Items');
		}else{
			$this->recordId 	= $id;
			$this->setLayout('item');
			if ($input->get('layout', '') == 'edit') {
				$this->form 		= $this->get('Form');
				$this->item 		= $this->get('Item');
			}else{
				$this->item 		= $this->get('DisplayItem');
			}
		}
		
		$this->params 		= $params;
		$this->pagination 	= $pagination;
		
		// Check for errors.
		if(count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Display the view
		parent::display($tpl);
	}
}
