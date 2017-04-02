<?php
/**
* @version		$Id: sliders.php 2017-03-26 16:51:19 surinder $
* @package		Slider
* @subpackage 	Models
* @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
* @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 *  Sliders Model class for Slider Component
 */
class SliderModelSliders extends JModelAdmin {
	
	/**
	* Model context string.
	*
	* @var		string
	*/
	protected $context = 'com_slider.sliders';
	
	/**
	 * @var object item
	 */
	protected $item;
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function populateState(){
		$app 		= JFactory::getApplication();

		// Load the object state.
		$id			= JRequest::getInt('id');
		$this->setState('sliders.id', $id);

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
		parent::populateState();
	}

	protected function getStoreId($id = ''){
		// Compile the store id.
		$id	.= ':'.$this->getState('sliders.id');
		return parent::getStoreId($id);
	}
	
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Slider', $prefix = 'SliderTable', $config = array()){
		return JTable::getInstance($type, $prefix, $config);
	}
	
	/**
     * Load an JSON string into the registry into the given namespace [or default if a namespace is not given]
     *
     * @param    string    JSON formatted string to load into the registry
     * @return    boolean True on success
     * @since    1.5
     * @deprecated 1.6 - Oct 25, 2010
     */
    public function loadJSON($data){
        return $this->loadString($data, 'JSON');
    }
	
	/**
	* Method to get Slider data.
	*
	* @param	integer	The id of the sliders.
	*
	* @return	mixed item data object on success, false on failure.
	*/
	public function getDisplayItem($id = null){
		if (!isset($this->item)){
			$id 	= $id?$id:$this->getState('sliders.id');
			//Get a table instance.
			//$table = JTable::getInstance('Slider', 'SliderTable');
			$query = $this->getListQuery();
			$query->where('a.id = '. (int)$id);

			$db		= $this->getDbo();
			$db->setQuery($query);
			$row = $db->loadObject();

			//Attempt to load the row.
			if($row){
				$this->item 	= $row;
			}elseif($error = $db->getError()){
				$this->setError($error);
				return false;
			}else{
				$this->setError("Slider record not found");
				return false;
			}
			$params = clone $this->getState('params');
			$this->item->params = $params;
		}
		return $this->item;
	}
	
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return  JDatabaseQuery
	 * @since   1.6
	 */
	protected function getListQuery(){
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.description, a.image, a.old_price, a.new_price, a.published, a.checked_out, a.checked_out_time, a.ordering, a.id'
			)
		);
		$query->from($db->quoteName('#__sl_slider').' AS a');
		
		// Join over the users for the checked out user.
		$query->select('uc.name AS uc_editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		
		
		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)){
			$query->where('a.published = '.(int) $published);
		} elseif ($published === ''){
			$query->where('(a.published IN (0, 1))');
		}


		// Filter by search in title
		$search = $this->getState('filter.search');
		if(!empty($search)){
			if (stripos($search, 'id:') === 0){
				$query->where('a.id = '.(int) substr($search, 3));
			}else{
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.description LIKE '.$search.')');
			}
		}

		// Add the list ordering clause.
		$orderCol	= $this->getState('list.ordering', 'a.description');
		$orderDirn	= $this->getState('list.direction', 'ASC');
		/*if ($orderCol == 'ordering' || $orderCol == 'category_title'){
			$orderCol = 'c.title '.$orderDirn.', a.ordering';
		}*/
		
		$query->order($db->escape($orderCol.' '.$orderDirn));

		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}
	
	/**
	* Method to get Sliders data.
	*
	*
	* @return	array array of item data objects on success, empty array on failure.
	*/
	public function getItems(){
		$db		= $this->getDbo();
		$db->setQuery($this->getListQuery());
		return $db->loadObjectList();
	}

		/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form. [optional]
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not. [optional]
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true){
		/*JForm::addFormPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/forms');
		JForm::addFormPath(JPATH_COMPONENT_ADMINISTRATOR . '/model/form');*/
		JForm::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/fields');
		JForm::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR . '/model/field');
		// Get the form.
		$form = $this->loadForm('com_slider.slider', 'slider', array('control' => 'jform', 'load_data' => $loadData));
		if(empty($form)){
			return false;
		}

		// Determine correct permissions to check.
		if ($this->getState('slider.id')){
			// Existing record. Can only edit in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.edit');
		}else{
			// New record. Can only create in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.create');
		}

		// Modify the form based on access controls.
		if (!$this->canEditState((object) $data)){
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('publish_up', 'disabled', 'true');
			$form->setFieldAttribute('publish_down', 'disabled', 'true');
			$form->setFieldAttribute('state', 'disabled', 'true');

			// Disable fields while saving.
			// The controller has already verified this is a record you can edit.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('publish_up', 'filter', 'unset');
			$form->setFieldAttribute('publish_down', 'filter', 'unset');
			$form->setFieldAttribute('state', 'filter', 'unset');
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData(){
		// Check the session for previously entered form data.
		$app  = JFactory::getApplication();
		$data = $app->getUserState('com_slider.edit.slider.data', array());

		if(empty($data)){
			$data = $this->getItem();


			// Prime some default values.
			if($this->getState('slider.id') == 0){
				$data->set('catid', $app->input->getInt('catid', $app->getUserState('com_slider.sliders.filter.category_id')));
			}
		}

		return $data;
	}
}
