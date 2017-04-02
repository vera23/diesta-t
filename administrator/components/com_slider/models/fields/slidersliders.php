<?php

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Form Field class.
 */
class JFormFieldSliderSliders extends JFormFieldList {
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	public $type = 'sliderSliders';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions(){
		$db		= JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('id AS value, description AS text');
		$query->from('#__sl_slider');
		$query->order('description DESC');

		// Get the options.
		$db->setQuery($query->__toString());

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}


		/*$options	= array_merge(
			parent::getOptions(),
			$options
		);*/

		return $options;
	}
	
	public function getListOptions(){
		return $this->getOptions();
	}
}