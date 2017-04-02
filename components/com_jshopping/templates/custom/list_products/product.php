<?php
/**
 * @version      4.14.3 05.11.2013
 * @author       MAXXmarketing GmbH
 * @package      Jshopping
 * @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
 * @license      GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php print $product->_tmp_var_start ?>
    <a href="<?php print $product->product_link ?>">
        <div class="product product-div text-center productitem_<?php print $product->product_id ?>">

            <div class="image">
                <?php if ($product->image) { ?>
                        <?php print $product->_tmp_var_image_block; ?>
                        <?php if ($product->label_id) { ?>
                            <div class="product_label">
                                <?php if ($product->_label_image) { ?>
                                    <img src="<?php print $product->_label_image ?>"
                                         alt="<?php print htmlspecialchars($product->_label_name) ?>"/>
                                <?php } else { ?>
                                    <span class="label_name"><?php print $product->_label_name; ?></span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                            <img class="jshop_img" src="<?php print $product->image ?>"
                                 alt="<?php print htmlspecialchars($product->name); ?>"
                                 title="<?php print htmlspecialchars($product->name); ?>"/>
                <?php } ?>

                <?php if ($this->allow_review) { ?>
                    <?php if (!$this->config->hide_product_rating) { ?>
                        <div class="review_mark">
                            <?php print showMarkStar($product->average_rating); ?>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php print $product->_tmp_var_bottom_foto; ?>
            </div>

            <div class="name">
                    <?php print $product->name ?>
                <?php if ($this->config->product_list_show_product_code) { ?>
                    <span class="jshop_code_prod">(<?php print _JSHOP_EAN ?>
                        : <span><?php print $product->product_ean; ?></span>)</span>
                <?php } ?>
            </div>
        </div>
    </a>
<?php print $product->_tmp_var_end ?>