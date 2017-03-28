<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);
$images = json_decode($this->item->images);
$date = new DateTime($this->item->publish_up)
?>
<?php if ($params->get('show_readmore') && $this->item->readmore) :
if ($params->get('access-view')) :
	$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
else :
	$menu = JFactory::getApplication()->getMenu();
	$active = $menu->getActive();
	$itemId = $active->id;
	$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
	$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
endif;endif; ?>

<div class="row media" style="margin-top: 0; margin-bottom: 15px;">
	<div class="pull-left">
		<span class="label label-info label-news-info"><?php echo $date->format('d-m-Y')?></span>
		<img class="media-object img-responsive img-thumbnail" src="<?php echo $images->image_intro?>"
			 style="max-width: 350px">    </div>
	<div class="media-body">
		<h4 class="media-heading"><a href="<?php echo $link; ?>" class="news-title-link"><?php echo $this->item->title?></a></h4>
		<div>
			<?php echo $this->item->introtext?>
		</div>
	</div>
</div>




