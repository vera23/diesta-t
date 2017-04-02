<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<link rel="stylesheet" href="components/com_slider/assets/home.css" type="text/css" />
<form class="row-fluid">
<?php if (!empty( $this->sidebar) && JRequest::getVar('tmpl')!='component') { ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
<?php } ?>
	<div id="j-main-container" class="span10">
		<div class="row-fluid">
			<div class="span9">
				<!-- <h1>LayoutType: Layout 2</h1> -->
				<div class="row-fluid homePage"><!--row-->
					<?php
					$views = json_decode('[{"view":"sliders","title":"SLIDERS"},'.
										'{"view":"help","title":"HELP"}]');
				
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
			</div>
			<div class="span3">
				<div class="accordion" id="accordionHomeRight" data-toggle="true">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionHomeRight" href="#collapseStatistics"><?php echo JText::_('COM_SLIDER_SIDEBARS_STATISTICS_TITLE'); ?></a>
						</div>
						<div id="collapseStatistics" class="accordion-body collapse in">
							<div class="accordion-inner">
								Statistics Info about your Slider_s component
							</div>
						</div>
					</div>
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionHomeRight" href="#collapseAbout"><?php echo JText::_('COM_SLIDER_SIDEBARS_ABOUT_TITLE'); ?></a>
						</div>
						<div id="collapseAbout" class="accordion-body collapse in">
							<div class="accordion-inner">
								<div style="background-color:#00FF00; padding:5px;"><small>you can edit me at "<?php $f = explode("components/", str_replace("\\", "/", __FILE__), 2); echo $f[1]; ?>"</small></div>
								<?php echo JText::_('COM_SLIDER_DESCRIPTION'); ?>
							</div>
						</div>
					</div>
				</div>
				
				<script>
					(function($){
						if(localStorage){
							$(document).ready(function() {
								var last=localStorage.sliderActiveAccordionGroup;
								if (last) {
									last = last.split(',');
									//remove default collapse settings
									$("#accordionHomeRight .collapse").removeClass('in');
									//show the last visible group
									for(var i=0; i<last.length; i++){
										$("#"+last[i]).collapse("show");
									}
								}					
								$("#accordionHomeRight").bind('shown', updateAccordionGroupSetting);
								$("#accordionHomeRight").bind('hide', updateAccordionGroupSetting);
								$("#accordionHomeRight").bind('hidden', updateAccordionGroupSetting);
							});
							
							//when a group is shown, save it as the active accordion group
							function updateAccordionGroupSetting() {
								var active = ['-1'];
								$("#accordionHomeRight .in").each(function(){
									active.push($(this).attr('id'));
								});					
								localStorage.sliderActiveAccordionGroup = active.join(',');
							}
						}
					})(jQuery)
				</script>
			</div>
		</div>
		<div class="row-fluid footer">
			<div class="span12">
				<div style="font-size: small;margin-top:20px;" class="well">
					<strong><span class="componentTitle">Slider_s</span> 0.0.0.1	</strong>
					<br>
					<span style="font-size: x-small">Copyright (C) 2017 Surinder Singh. All rights reserved. / http://developerextensions.com</span>
					<br><br>
					<div>
						<img src="components/com_slider/assets/48x48/at-sign.png" align="left" border="0" style="margin-right:10px;">
						<b>Web. <a href="http://developerextensions.com" target="_blank" style="color:#000;">http://developerextensions.com</a></b>
						<br>
						<b><a href="mailto:surinder83singh@gmail.com" target="_blank">surinder83singh@gmail.com</a></b>
					</div>
					<br>
					<div style="padding:2px 0 40px 0">
						<img src="components/com_slider/assets/48x48/question-mark.png" align="left" border="0" style="margin-right:15px;">
						<a href="http://developerextensions.com" target="_blank" style="color:#000;"><b>Help / Support</b></a>
					</div>	
					<strong>
						If you use Slider_s, please post a rating and a review at the
						<a href="#">Joomla! Extensions Directory</a>.
					</strong>
					<br>
					<span style="font-size: x-small">
						Slider_s is Free software released under the
						<a target="_blank" href="http://www.gnu.org/licenses/gpl.html">GNU General Public License,</a>
						version 3 of the license or -at your option- any later version
						published by the Free Software Foundation.
					</span>	
				</div>		
			</div>
		</div>
	</div>
</form>	