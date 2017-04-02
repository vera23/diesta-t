<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_slider
 *
 * @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
 * @license 	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

/**
 * Banner model.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_slider
 * @since       1.6
 */
class SliderModelSlider extends JModelAdmin {
	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_SLIDER_SLIDER';

	/**
	 * Batch copy/move command. If set to false, 
	 * the batch copy/move command is not supported
	 *
	 * @var string
	 */
	protected $batch_copymove = false;

	/**
	 * Allowed batch commands
	 *
	 * @var array
	 */
	protected $batch_commands = array(
		/*'assetgroup_id' => 'batchAccess',
		'language_id' => 'batchLanguage',
		'tag' => 'batchTag'*/
		
	);

	/**
	 * Method to perform batch operations on an item or a set of items.
	 *
	 * @param   array  $commands  An array of commands to perform.
	 * @param   array  $pks       An array of item ids.
	 * @param   array  $contexts  An array of item contexts.
	 *
	 * @return  boolean  Returns true on success, false on failure.
	 *
	 * @since   12.2
	 */
	public function batch($commands, $pks, $contexts){
		// Sanitize ids.
		$pks = array_unique($pks);
		JArrayHelper::toInteger($pks);

		// Remove any values of zero.
		if (array_search(0, $pks, true)) {
			unset($pks[array_search(0, $pks, true)]);
		}

		if (empty($pks)) {
			$this->setError(JText::_('JGLOBAL_NO_ITEM_SELECTED'));

			return false;
		}

		$done = false;
		$this->jversion 	= new JVersion;
		// Set some needed variables.
		$this->user = JFactory::getUser();
		$this->table = $this->getTable();
		$this->tableClassName = get_class($this->table);
		if ($this->jversion->isCompatible('3.4')){		
			$this->contentType = new JUcmType;
			$this->type = $this->contentType->getTypeByTable($this->tableClassName);
			$this->batchSet = true;

			if ($this->type == false) {
				$type = new JUcmType;
				$this->type = $type->getTypeByAlias($this->typeAlias);
			}
			$this->tagsObserver = $this->table->getObserverOfClass('JTableObserverTags');
		}

		

		if ($this->batch_copymove && !empty($commands[$this->batch_copymove])) {
			$cmd = JArrayHelper::getValue($commands, 'move_copy', 'c');

			if ($cmd == 'c') {
				$result = $this->batchCopy($commands[$this->batch_copymove], $pks, $contexts);

				if (is_array($result)) {
					foreach ($result as $old => $new) {
						$contexts[$new] = $contexts[$old];
					}
					$pks = array_values($result);
				} else {
					return false;
				}
			} elseif ($cmd == 'm' && !$this->batchMove($commands[$this->batch_copymove], $pks, $contexts)) {
				return false;
			}

			$done = true;
		}

		foreach ($this->batch_commands as $identifier => $command) {
			if (strlen($commands[$identifier]) > 0) {
				if (!$this->$command($commands[$identifier], $pks, $contexts)) {
					return false;
				}

				$done = true;
			}
		}

		if (!$done)	{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_INSUFFICIENT_BATCH_INFORMATION'));

			return false;
		}

		// Clear the cache
		$this->cleanCache();

		return true;
	}


	/**
	 * Batch change a items field.
	 *
	 * @param   string   $tablename     name of remote table
	 * @param   string   $tablePrefix     prefix of table
	 * @param   string   $field     this table's key/field belong to primery key of $tablename  [$value]
	 * @param   integer  $value     primery key value of $tablename table.
	 * @param   array    $pks       An array of row IDs.
	 * @param   array    $contexts  An array of item contexts.
	 *
	 * @return  mixed  An array of new IDs on success, boolean false on failure.
	 *
	 * @since	2.5
	 */
	protected function batchChangeFields($tablename, $tablePrefix, $field, $value, $pks, $contexts){
		$id = (int) $value;

		$table 		= $this->getTable();
		$TABLENAME 	= strtoupper($tablename);
		$i 			= 0;

		// Check that the record exists
		if ($id){
			$parentTable = $this->getTable($tablename, $tablePrefix);

			if (!$parentTable){
				$this->setError(JText::_('COM_SLIDER_ERROR_BATCH_MOVE_'.$TABLENAME.'_TABLE_NOT_FOUND'));
				return false;
			}

			if (!$parentTable->load($id)){
				if ($error = $parentTable->getError()){
					// Fatal error
					$this->setError($error);
					return false;
				}else{
					$this->setError(JText::_('COM_SLIDER_ERROR_BATCH_MOVE_'.$TABLENAME.'_NOT_FOUND'));
					return false;
				}
			}
		}

		if (empty($id)){
			//$this->setError(JText::_('COM_SLIDER_ERROR_BATCH_MOVE_'.$TABLENAME.'_NOT_FOUND'));
			//return false;
			$id = '0';
		}


		if ($this->jversion->isCompatible('3.4') && empty($this->batchSet))	{
			// Set some needed variables.
			$this->user = JFactory::getUser();
			$this->table = $this->getTable();
			$this->tableClassName = get_class($this->table);
			$this->contentType = new JUcmType;
			$this->type = $this->contentType->getTypeByTable($this->tableClassName);
		}

		// Parent exists so we proceed
		foreach ($pks as $pk) {
			// Check that the user has permission
			if (!$this->user->authorise('core.edit', $contexts[$pk])) {
				$this->setError(JText::_('COM_SLIDER_ERROR_BATCH_CANNOT_EDIT'));

				return false;
			}

			// Check that the row actually exists
			if (!$this->table->load($pk)) {
				if ($error = $this->table->getError()) {
					// Fatal error
					$this->setError($error);

					return false;
				} else {
					// Not fatal error
					$this->setError(JText::sprintf('COM_SLIDER_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
					continue;
				}
			}

			// Set the new ID
			$this->table->$field = $id;

			// Check the row.
			if (!$this->table->check())	{
				$this->setError($this->table->getError());

				return false;
			}

			// Store the row.
			if (!$this->table->store()) {
				$this->setError($this->table->getError());

				return false;
			}
		}

		// Clean the cache
		$this->cleanCache();

		return true;
	}

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canDelete($record){
		if (!empty($record->id)){
			if ($record->published != -2){
				return;
			}
			
			return parent::canDelete($record);
		}
	}
	/**
	 * Method to test whether a record can have its state changed.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canEditState($record){
		
		return parent::canEditState($record);
	}

	/**
	 * Returns a JTable object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate. [optional]
	 * @param   string  $prefix  A prefix for the table class name. [optional]
	 * @param   array   $config  Configuration array for model. [optional]
	 *
	 * @return  JTable  A database object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Slider', $prefix = 'SliderTable', $config = array()){
		return JTable::getInstance($type, $prefix, $config);
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

	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param   JTable  $table  A record object.
	 *
	 * @return  array  An array of conditions to add to add to ordering queries.
	 *
	 * @since   1.6
	 */
	protected function getReorderConditions($table){
		$condition = array();
		$condition[] = 'catid = '. (int) $table->catid;
		$condition[] = 'state >= 0';
		return $condition;
	}

	/**
	 * @since  3.0
	 */
	protected function prepareTable($table){
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		if (empty($table->id)){
			// Set the values
			$table->created	= $date->toSql();
			// Set ordering to the last item if not set
			if (empty($table->ordering)){
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__sl_slider');
				$max = $db->loadResult();

				$table->ordering = $max + 1;
			}
		}else{
			// Set the values
			$table->modified	= $date->toSql();
			$table->modified_by	= $user->get('id');
		}		
	}
}
