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
<div class="jshop margin-bottom-85" id="comjshop">

    <h1 class="header margin-bottom-85"><?php print $this->manufacturer->name?></h1>
    
    <div class="manufacturer_description">
        <?php print $this->manufacturer->description;?>
    </div>
    
    <?php if ($this->display_list_products){ ?>
    <div class="jshop_list_product">
    <?php
        include(dirname(__FILE__)."/../".$this->template_block_form_filter);
        if (count($this->rows)){
            include(dirname(__FILE__)."/../".$this->template_block_list_product);
        }else{
            include(dirname(__FILE__)."/../".$this->template_no_list_product);
        }
        if ($this->display_pagination){
            include(dirname(__FILE__)."/../".$this->template_block_pagination);
        }
    ?>
    </div>
    <?php }?>
</div>