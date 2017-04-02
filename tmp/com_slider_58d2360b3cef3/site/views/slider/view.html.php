<?php
/**
 * @package    slider
 * @subpackage Views
 * @author      {@link }
 * @author     Created on 22-Mar-2017
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


/**
 * HTML View class for the slider Component.
 *
 * @package slider
 */
class sliderViewslider extends JViewLegacy
{
    /**
     * slider view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return void
     */
    public function display($tpl = null)
    {
        $this->greeting = 'Hello World!';

        parent::display($tpl);
    }
}
