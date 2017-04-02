<?php
defined('_JEXEC') or die('Restricted access'); 

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
?>

<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(task){
		if (task == 'slider.cancel' || document.formvalidator.isValid(document.id('slider-form'))){
			Joomla.submitform(task, document.getElementById('slider-form'));
		}
	}
	window.addEvent('domready', function(){
		//add your custom js here
	});
</script>
<style>
	textarea{width:99% !important}
</style>

<form action="<?php echo JRoute::_('index.php?option=com_slider&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="slider-form" class="form-validate form-horizontal">
<!-- Begin Slider -->
	 	<div class="span7">
		  <fieldset class="adminform">
		  	<ul class="nav nav-tabs">
				<li class="active"><a href="#details" data-toggle="tab"><?php echo JText::_( 'Details' ); ?></a></li>
				<li><a href="#settings" data-toggle="tab"><?php echo JText::_( 'Settings' ); ?></a></li>
				<li><a href="#permissions" data-toggle ="tab"><?php echo JText::_( 'Permissions' ); ?></a></li>
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
				<div class="tab-pane" id="permissions">
					<?php echo $this->form->getInput('rules');?>
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
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>