<?php
/**
 * @package    kghhvjh
 * @subpackage Views
 * @author      {@link }
 * @author     Created on 22-Mar-2017
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


/**
 * HTML View class for the kghhvjh Component.
 *
 * @package kghhvjh
 */
class kghhvjhViewkghhvjh extends JViewLegacy
{
    /**
     * kghhvjh view display method.
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
