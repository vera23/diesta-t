<?php 
/**
* @version      4.8.0 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
?>
<div class="jshop" id="comjshop">
    <h1><?php print _JSHOP_USER_GROUPS_INFO?></h1>
    
    <?php echo $this->_tmpl_start?>
    <table class="groups_list">
    <tr>
        <th class="title"><?php print _JSHOP_TITLE?></th> 
        <th class="discount"><?php print _JSHOP_DISCOUNT?></th> 
    </tr>
    <?php foreach($this->rows as $row) : ?>
        <tr>
            <td class="title"><?php print $row->name?></td> 
            <td class="discount"><?php print floatval($row->usergroup_discount)?>%</td>
        </tr>
    <?php endforeach; ?>
    </table>
    
    <?php echo $this->_tmpl_end?>
</div>