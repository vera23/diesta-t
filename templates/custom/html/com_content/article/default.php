<?php
/**
 * @package        Joomla.Site
 * @subpackage    com_content
 * @copyright    Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
// Create shortcuts to some parameters.
$params = $this->item->params;
$images = json_decode($this->item->images);
$urls = json_decode($this->item->urls);
$date = new DateTime($this->item->publish_up);
?>
<div class="row">
    <h1 class="header">
        <?php echo $this->escape($this->item->title); ?>
    </h1>
    <div class="col-md-12 col-xs-12">
        <span class="label label-info" style="margin-bottom: 10px"><?php echo $date->format('d-m-Y') ?></span>
        <div class="pull-left" style="margin-right: 20px;">
            <img src="<?php echo $images->image_intro ?>" class="img-responsive" style="max-width: 350px; margin-bottom: 20px;: ">
        </div>
        <p>
            <?php echo $this->item->introtext ?>
        </p>

        <hr>
        <div class="margin-bottom-85">
            <?php echo $this->item->fulltext ?>
        </div>
    </div>
</div>