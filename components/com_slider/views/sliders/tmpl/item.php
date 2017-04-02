<?php 

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

if (!isset($this->form)){
$item	= $this->item;
?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h2><?php echo $this->params->get('page_title');  ?></h2></div>
<div><h4><?php echo JText::_('COM_SLIDER_SLIDERS_VIEW_ITEM_PAGE_DESC'); ?></h4></div>
<a href="<?php echo JRoute::_('index.php?option=com_slider'); ?>" class="btn pull-right btn-primary"><?php echo JText::_('COM_SLIDER_BUTTON_HOME'); ?></a>
<h1>
	<?php
		echo $item->description;
	?>
</h1>
<div class="contentpane">
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
</tbody>
</table>
</div>
<h3>"Page Display" menu/link Parameters</h3>
<?php
echo '<h3>Following params will be editable in backend under "Parameters" on Slider edit form only if table has "params" field as varchar</h3>';
echo 'Param1: <b>'.$item->params->get('param1', 'default')." </b><br />";
echo 'Param2: <b>'.$item->params->get('param2', 'default')." </b><br />";
$param3 = $item->params->get('param3', 'default');
if($param3!='default'){
	$param3 = '<img src="'.$param3.'"  width="100" height="100" />';
}
echo 'Param3: '.$param3."<br />";

}else{

$isNew 	= !$this->recordId || $this->recordId == '0';
JHtml::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');
?>

<script language="javascript" type="text/javascript">
	
	(function ($){
		$(document).ready(function() {
			Joomla.submitbutton = function(task){
				if (task == 'slider.cancel' || document.formvalidator.isValid(document.id('slider-form'))){
					Joomla.submitform(task, document.getElementById('slider-form'));
				}
			}
			$('*[rel=tooltip]').tooltip();

			// Turn radios into btn-group
			$('.radio.btn-group label').addClass('btn');
			$('.btn-group label:not(.active)').click(function() {
				var label = $(this);
				var input = $('#' + label.attr('for'));

				if (!input.prop('checked')) {
					label.closest('.btn-group').find('label').removeClass('active btn-success btn-danger btn-primary');
					if (input.val() == '') {
						label.addClass('active btn-primary');
					} else if (input.val() == 0) {
						label.addClass('active btn-danger');
					} else {
						label.addClass('active btn-success');
					}
					input.prop('checked', true);
					input.trigger('change');
				}
			});
			$('.btn-group input[checked=checked]').each(function() {
				if ($(this).val() == '') {
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-primary');
				} else if ($(this).val() == 0) {
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-danger');
				} else {
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-success');
				}
			});
			// add color classes to chosen field based on value
			$('select[class^="chzn-color"], select[class*=" chzn-color"]').on('liszt:ready', function(){
				var select = $(this);
				var cls = this.className.replace(/^.(chzn-color[a-z0-9-_]*)$.*/, '\1');
				var container = select.next('.chzn-container').find('.chzn-single');
				container.addClass(cls).attr('rel', 'value_' + select.val());
				select.on('change click', function()
				{
					container.attr('rel', 'value_' + select.val());
				});

			});
		});
	})(jQuery);
</script>
<style>
	textarea{width:99% !important}
	.checkboxes.input li{list-style: none;}
	.checkboxes.input label{display: inline-block; margin-left: 5px;}
	.checkboxes.input input[type="checkbox"]{margin-bottom: 4px; margin-top: 0px;}
</style>

<form action="<?php echo JRoute::_('index.php?option=com_slider&view=sliders&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="slider-form" class="form-validate form-horizontal">
<!-- Begin Slider -->
 	<div class="span7">
	  <fieldset class="adminform">
	  	<ul class="nav nav-tabs">
			<li class="active"><a href="#details" data-toggle="tab"><?php echo JText::_( 'Details' ); ?></a></li>
			<li><a href="#settings" data-toggle="tab"><?php echo JText::_( 'Settings' ); ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="details">
					
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('description');  ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('image'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('image');  ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('old_price'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('old_price');  ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('new_price'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('new_price');  ?></div>
				</div>			
			</div>
			<div class="tab-pane" id="settings">
					
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('published'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('published');  ?></div>
				</div>
			</div>
		</div>
      </fieldset>
    </div>
    <div class="span2">
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Options' ); ?></legend>
					
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('created');  ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('created_by');  ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('created_by_alias'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('created_by_alias');  ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('modified'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('modified');  ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('modified_by'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('modified_by');  ?></div>
				</div>								
		</fieldset>
		        

    </div>
	<div class="clearfix"></div>
	<div class="form-actions">
		<input class="btn btn-primary validate" type="submit" value="Save" />
		<input class="btn btn-primary" type="submit" onclick="javascript: if(document.formvalidator.isValid(this.form)){this.form['task'].value='slider.apply';}else{return false;}" value="Apply" />
		<button class="btn" onclick="javascript: this.form['task'].value='slider.cancel'; this.form.submit();"><?php if($isNew){echo 'Cancel';}else{ echo 'Close';} ?></button>
		<input type="hidden" name="option" value="com_slider" />
		<input type="hidden" name="task" value="slider.save" />
		<input type="hidden" name="id" value="<?php echo (int) $this->item->id; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<?php } ?>

