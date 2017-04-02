<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<form class="row-fluid">
<?php if (!empty( $this->sidebar) && JRequest::getVar('tmpl')!='component') { ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php }else{ ?>
	<div id="j-main-container">
<?php } ?>
		<div><h2>Help informations</h2></div>
		<div class="accordion" id="accordionHelp">
		  	<?php 
			$key = JRequest::getVar('key');
			if($key){
				echo $this->loadTemplate($key);
			}else{
				$helpForViews = array('sliders');
				foreach($helpForViews as $helpForView){
					echo $this->loadTemplate($helpForView);
				}
			}
		?>
		</div>
		
	</div>
</form>	