<?php
/**
* @version      4.6.1 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view');

class JshoppingViewCountries extends JViewLegacy
{
    function displayList($tpl=null){        
        JToolBarHelper::title( _JSHOP_LIST_COUNTRY, 'generic.png' ); 
        JToolBarHelper::addNew();
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl=null){
        JToolBarHelper::title( $temp = ($this->edit) ? (_JSHOP_EDIT_COUNTRY.' / '.$this->country->{JSFactory::getLang()->get('name')}) : (_JSHOP_NEW_COUNTRY), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>