<?php
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= $user->authorise('core.edit.state', 'com_slider.category');
	
$archived	= $this->state->get('filter.published') == 2 ? true : false;
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
$params		= (isset($this->state->params)) ? $this->state->params : new JObject;
$saveOrder	= $listOrder == 'ordering';
if ($saveOrder){
	$saveOrderingUrl = 'index.php?option=com_slider&task=sliders.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();

?>
<script type="text/javascript">
	Joomla.orderTable = function(){
		table 		= document.getElementById("sortTable");
		direction 	= document.getElementById("directionTable");
		order 		= table.options[table.selectedIndex].value;
		if(order != '<?php echo $listOrder; ?>'){
			dirn = 'asc';
		}else{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_slider&view=sliders'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) { ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php }else{ ?>
	<div id="j-main-container">
<?php } ?>
	<div id="filter-bar" class="btn-toolbar">
		<div class="filter-search btn-group pull-left">
			<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_SLIDER_SEARCH_SLIDER_TITLE'); ?></label>
			<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_SLIDER_SEARCH_SLIDER_TITLE'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_SLIDER_SEARCH_SLIDER_TITLE'); ?>" />
		</div>
		<div class="btn-group pull-left">
			<button type="submit" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
			<button type="button" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
		</div>
		<div class="btn-group pull-right hidden-phone">
			<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		<div class="btn-group pull-right hidden-phone">
			<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
			<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
				<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
				<option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
				<option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
			</select>
		</div>
		<div class="btn-group pull-right">
			<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
			<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
				<option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
				<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
			</select>
		</div>
	</div>
	<div class="clearfix"> </div>
		<table class="table table-striped" id="articleList">
			<thead>
				<tr>
					<th width="1%" class="nowrap center hidden-phone">#</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
					</th>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>			
		
				
					<th class="title">
						<?php echo JHTML::_('grid.sort', 'COM_SLIDER_SLIDERS_HEADING_DESCRIPTION', 'a.description', $listDirn, $listOrder ); ?>
					</th>								
					<th class="title">
						<?php echo JHTML::_('grid.sort', 'COM_SLIDER_SLIDERS_HEADING_IMAGE', 'a.image', $listDirn, $listOrder ); ?>
					</th>								
					<th class="title">
						<?php echo JHTML::_('grid.sort', 'COM_SLIDER_SLIDERS_HEADING_OLD_PRICE', 'a.old_price', $listDirn, $listOrder ); ?>
					</th>								
					<th class="title">
						<?php echo JHTML::_('grid.sort', 'COM_SLIDER_SLIDERS_HEADING_NEW_PRICE', 'a.new_price', $listDirn, $listOrder ); ?>
					</th>								
					<th class="title">
						<?php echo JHTML::_('grid.sort', 'COM_SLIDER_SLIDERS_HEADING_PUBLISHED', 'a.published', $listDirn, $listOrder ); ?>
					</th>								
					<th class="title">
						<?php echo JHTML::_('grid.sort', 'COM_SLIDER_SLIDERS_HEADING_ID', 'a.id', $listDirn, $listOrder ); ?>
					</th>				
				</tr>
			</thead>
			<!--<tfoot>
				<tr>
					<td colspan="12">
						<?php //echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>-->
		<tbody>
	<?php
	$k = 0;
	if (count( $this->items ) > 0 ){	  
		for ($i=0; $i < count( $this->items ); $i++){
		$row 		= &$this->items[$i];
		
		$link 		= JRoute::_( 'index.php?option=com_slider&task=slider.edit&id='. $row->id );
		$row->id 	= $row->id;
		$checked 	= JHTML::_('grid.checkedout', $row, $i );
		$canCheckin = $user->authorise('core.manage',     'com_checkin') || $row->checked_out == $userId || $row->checked_out == 0;

	
		$published 	= JHTML::_('jgrid.published', $row->published, $i , 'sliders.');
	
		$canChange  = $user->authorise('core.edit.state', 'com_slider');
		$canEdit    = $user->authorise('core.edit',       'com_slider.slider'. $row->id);
	  ?>
		<tr class="<?php echo "row$k"; ?>" >		
			<td align="center hidden-phone"><?php echo $this->pagination->getRowOffset($i); ?>.</td>
			<td class="order nowrap center hidden-phone">
				<?php if ($canChange) {
					$disableClassName = '';
					$disabledLabel	  = '';
					if (!$saveOrder) {$disabledLabel    = JText::_('JORDERINGDISABLED');$disableClassName = 'inactive tip-top';	} ?>
					<span class="sortable-handler hasTooltip <?php echo $disableClassName; ?>" title="<?php echo $disabledLabel; ?>">
						<i class="icon-menu"></i>
					</span>
					<input type="text" style="display:none" name="order[]" size="5"	value="<?php echo $row->ordering; ?>" class="width-20 text-area-order " />
				<?php }else{ ?>
					<span class="sortable-handler inactive" >
						<i class="icon-menu"></i>
					</span>
				<?php } ?>
			</td>
			
			<td><?php echo $checked  ?></td>	
	
			<td>
				<div class="pull-left">
					<?php if ($row->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $row->uc_editor, $row->checked_out_time, 'sliders.', $canCheckin); ?>
					<?php endif; ?>
					<?php if ($canEdit) { ?>
						<a href="<?php echo JRoute::_('index.php?option=com_slider&task=slider.edit&id='.(int) $row->id); ?>">
							<?php echo $this->escape($row->description); ?></a>
					<?php } else { ?>
						<?php echo $this->escape($row->description); ?>
					<?php } ?>
				</div>									
			</td>        	<td><?php echo $row->image; ?></td>
        	<td><?php echo $row->old_price; ?></td>
        	<td><?php echo $row->new_price; ?></td>
        	<td><?php echo $published; ?></td>
        	<td><?php echo $row->id; ?></td>
		
		</tr>
	<?php
	  $k = 1 - $k;
	  }
	  }else{
	?>
		<tr>
			<td colspan="12">
				<?php echo JText::_( 'COM_SLIDER_NO_ITEM' ); ?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
<?php echo $this->pagination->getListFooter(); ?>
<?php echo $this->loadTemplate('batch'); ?>
	

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
	</div>
</form>