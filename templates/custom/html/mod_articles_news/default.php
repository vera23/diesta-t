<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


?>
<!--<div class="newsflash<?php /*echo $moduleclass_sfx; */?>">
	<?php /*foreach ($list as $item) : */?>
		<?php /*require JModuleHelper::getLayoutPath('mod_articles_news', '_item'); */?>
	<?php /*endforeach; */?>
</div>-->
<div id="news">
	<div class="container text-center">
		<h3 class="header margin-bottom-85">
			Новости
		</h3>
		<a href="/news" class="all-link pull-right">Все новости</a>
		<div class="row">

			<?php foreach ($list as $item) : ?>
				<? $images  = json_decode($item->images); ?>
				<div class="col-xs-12 col-lg-4 col-md-4">
					<a href="<?php echo $item->link?>" class="news-link">
						<div class="news">
							<img class="news-img" src="<?php echo '/'.$images->image_intro?>">
							<div class="news-title"><?= $item->title ?></div>
						</div>
						<div class="news-preview text-center margin-top-20">
							<?echo $item->introtext?>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

