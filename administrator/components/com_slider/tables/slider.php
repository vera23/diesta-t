<?php
defined('_JEXEC') or die('Restricted access');

/**
* @version		$Id:sliders.php  2017-03-26 16:51:19 surinder $
* @package		Slider
* @subpackage 	Tables
* @copyright	Copyright (C) 2017, Surinder Singh. All rights reserved.
* @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/


/**
* SliderTableSlider class
*
* @package		Slider
* @subpackage	Tables
*/
class SliderTableSlider extends JTable{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar description  **/
   public $description = null;

   /** @var tinyint published  **/
   public $published = null;

   /** @var datetime created  **/
   public $created = "0000-00-00 00:00:00";

   /** @var int unsigned created_by  **/
   public $created_by = null;

   /** @var varchar created_by_alias  **/
   public $created_by_alias = null;

   /** @var datetime modified  **/
   public $modified = "0000-00-00 00:00:00";

   /** @var int unsigned modified_by  **/
   public $modified_by = null;

   /** @var int unsigned checked_out  **/
   public $checked_out = null;

   /** @var datetime checked_out_time  **/
   public $checked_out_time = "0000-00-00 00:00:00";

   /** @var varchar image  **/
   public $image = null;

   /** @var int ordering  **/
   public $ordering = null;

   /** @var int old_price  **/
   public $old_price = null;

   /** @var int new_price  **/
   public $new_price = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db){
		parent::__construct('#__sl_slider', 'id', $db);
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/
	public function bind($array, $ignore = ''){ 


		return parent::bind($array, $ignore);		
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function check(){
		if ($this->id === 0) {
			//get next ordering
			$this->ordering = $this->getNextOrder( );

		}
		
		if (!$this->created) {
			$date = JFactory::getDate();
			$this->created = $date->format("Y-m-d H:i:s");
		}				
		/** check for valid name */
		/*
		if (trim($this->description) == '') {
			$this->setError(JText::_('Your Sliders must contain a description.')); 
			return false;
		}
		**/

		return true;
	}

	/**
	 * Method to compute the default name of the asset.
	 * The default name is in the form `table_name.id`
	 * where id is the value of the primary key of the table.
	 *
	 * @return	string
	 * @since	2.5
	 */
	protected function _getAssetName() {
		$k = $this->_tbl_key;
		return 'com_slider.slider.'.(int) $this->$k;
	}

	/**
	 * Method to return the title to use for the asset table.
	 *
	 * @return	string
	 * @since	2.5
	 */
	protected function _getAssetTitle() {
		return $this->description;
	}

	/**
	 * Method to get the parent asset under which to register this one.
	 * By default, all assets are registered to the ROOT node with ID,
	 * which will default to 1 if none exists.
	 * The extended class can define a table and id to lookup.  If the
	 * asset does not exist it will be created.
	 *
	 * @param   JTable   $table  A JTable object for the asset parent.
	 * @param   integer  $id     Id to look up
	 *
	 * @return  integer
	 *
	 * @since   11.1
	 */
	protected function _getAssetParentId(JTable $table = null, $id = null) {
		// For simple cases, parent to the asset root.
		$assets = self::getInstance('Asset', 'JTable', array('dbo' => $this->getDbo()));

		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assets->getRootId();
 
		// Find the parent-asset
		$assets->loadByName('com_slider');

		// Return the found asset-parent-id
		if ($assets->id) {
			$assetParentId=$assets->id;
		}

		if (!empty($assetParentId)) {
			return $assetParentId;
		}

		return 1;
	}
}
