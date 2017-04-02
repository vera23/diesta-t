<?php

defined('_JEXEC') or die('Restricted access');
$published = $this->state->get('filter.published');
?>

<div class="modal hide fade" id="collapseModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&#215;</button>
		<h3><?php echo JText::_('COM_SLIDER_BATCH_SLIDERS_OPTIONS'); ?></h3>
	</div>
	<div class="modal-body modal-batch">
		<p><?php echo JText::_('COM_SLIDER_BATCH_TIP'); ?></p>

		<div class="row-fluid">
		</div>
	</div>
	<div class="modal-footer">
		<script type="text/javascript">
			function resetBatchForm(){
				var ids = [];
				for(var i =0; i<ids.length; i++){
					jQuery('#'+ids[i]).val('').trigger('liszt:updated.chosen').trigger('liszt:updated');
				}
			}
		</script>
		<button class="btn" type="button" onclick="resetBatchForm()" data-dismiss="modal">
			<?php echo JText::_('JCANCEL'); ?>
		</button>
		<button class="btn btn-primary" type="submit" onclick="Joomla.submitbutton('slider.batch');">
			<?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
		</button>
	</div>
</div>