<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Slider
 * @author     Miroshnichenko Vera Mikhailovna <veramir10@gmail.com>
 * @copyright  2017 Miroshnichenko Vera Mikhailovna
 * @license    GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Slider controller class.
 *
 * @since  1.6
 */
class SliderControllerSlider extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'sliders';
		parent::__construct();
	}
}
