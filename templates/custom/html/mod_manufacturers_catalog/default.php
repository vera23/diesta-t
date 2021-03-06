<?php /*
/**
* @version      4.9.1 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
?>

<div id="providers">
    <div class="container text-center">
        <h3 class="header margin-bottom-85">
            Поставщики
        </h3>
        <a href="#" class="all-link pull-right">Все поставщики</a>
        <div class="row">
            <?php foreach($list as $curr):?>
                <a href="<?php echo  $curr->link?>">
                    <div class="col-xs-12 col-lg-4 col-md-4">
                        <img class="provider-logo" src="<?php echo $jshopConfig->image_manufs_live_path."/".$curr->manufacturer_logo?>" alt = "<?php echo $curr->name?>" />
                        <div class="provider-name col-sm-12 fsize-18">
                            <?php echo $curr->name?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>