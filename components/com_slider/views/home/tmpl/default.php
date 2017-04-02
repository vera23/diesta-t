<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<h1 class="componentTitle"><?php echo JText::_('COM_SLIDER'); ?></h1>
<link rel="stylesheet" href="<?php echo JURI::root(); ?>administrator/components/com_slider/assets/home.css" type="text/css" />
<!-- <h1>LayoutType: Layout 2</h1> -->
<div class="row-fluid homePage"><!--row-->
	<?php
	$views = json_decode('[{"view":"sliders","title":"SLIDERS"}]');

	$linkPrefix = 'index.php?option=com_slider&view=';
	$iconPath   = JURI::root().'administrator/components/com_slider/assets/48x48/';
	$i=0;
	foreach($views as $view){
		$link = isset($view->link) ? $view->link : $linkPrefix.$view->view;
		echo "\n".'					<a class="span2" href="'. $link .'"><div class="btn btn-xlarge"><div class="img" style="background-image:url('.$iconPath.strtolower($view->view).'.png)"></div>'.JText::_('COM_SLIDER_CPANEL_ITEM_'.$view->title).'</div></a>';
		$i++;
		if($i!=0 && $i%6==0){
			echo "</div><!--/row-->\n					<br /><div class='row-fluid homePage'><!--row-->\n";
		}
	}		
	?>
</div><!--/row-->
