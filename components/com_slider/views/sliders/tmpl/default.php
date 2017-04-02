<?php 

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h2><?php echo $this->params->get('page_title');  ?></h2></div>
<div>
	<h4><?php echo JText::_('COM_SLIDER_SLIDERS_VIEW_DEFAULT_PAGE_DESC'); ?></h4>
	<a href="<?php echo JRoute::_('index.php?option=com_slider&task=slider.add'); ?>" class="btn pull-right"><?php echo JText::_('COM_SLIDER_ADD_SLIDER'); ?></a>
	<a href="<?php echo JRoute::_('index.php?option=com_slider'); ?>" style="margin-left:5px;margin-right:5px" class="btn pull-right btn-primary"><?php echo JText::_('COM_SLIDER_BUTTON_HOME'); ?></a>
</div>
<table class="table table-condensed table-hover">
<thead>
	<tr>
		
		<th><?php echo JText::_('COM_SLIDER_SLIDERS_HEADING_DESCRIPTION'); ?></th>
		<th><?php echo JText::_('COM_SLIDER_SLIDERS_HEADING_IMAGE'); ?></th>
		<th><?php echo JText::_('COM_SLIDER_SLIDERS_HEADING_OLD_PRICE'); ?></th>
		<th><?php echo JText::_('COM_SLIDER_SLIDERS_HEADING_NEW_PRICE'); ?></th>
		<th><?php echo JText::_('COM_SLIDER_SLIDERS_HEADING_PUBLISHED'); ?></th>
		<th><?php echo JText::_('COM_SLIDER_SLIDERS_HEADING_ORDERING'); ?></th>
		<th><?php echo JText::_('COM_SLIDER_SLIDERS_HEADING_ID'); ?></th>

	</tr>
</thead>
<tbody>
<?php 
foreach($this->items as $item){ ?>
	<tr>

		<td>
			<a href="index.php?option=com_slider&view=sliders&id=<?php echo $item->id; ?>">
				<?php
				echo $item->description;
				?>
			</a>
		</td>
		<td><?php echo $item->image; ?></td>
		<td><?php echo $item->old_price; ?></td>
		<td><?php echo $item->new_price; ?></td>
		<td><?php echo $item->published; ?></td>
		<td><?php echo $item->ordering; ?></td>
		<td><a href="<?php echo JRoute::_('index.php?option=com_slider&view=sliders&layout=edit&id='.$item->id); ?>" class="btn"><?php echo JText::_('COM_SLIDER_BUTTON_EDIT'); ?></a></td>
	</tr>
<?php } ?>
</tbody>
</table>

