<div class="slider">
    <ul class="bxslider">
        <? foreach ($objects as $item) : ?>
            <li><img src="/images/<?php echo $item['image'] ?>">
                <div class="container">
                    <?php if (isset($item['description'])): ?>
                        <div id="advertising" class="fsize-33 col-sm-7 col-lg-7 col-xs-12">
                            <? echo $item['description'] ?>

                            <div class="prices margin-top-40">
                                <?php if (isset($item['old_price'])) : ?>
                                    <span class="tahoma"><?php echo $item['old_price'] ?> руб</span>
                                <? endif ?>
                                <?php if (isset($item['new_price'])) : ?>
                                    <span
                                        class="margin-left-30 font-red fsize-40"><?php echo $item['new_price'] ?>
                                        руб</span>
                                <? endif ?>
                            </div>
                        </div>
                    <?php endif ?>

                </div>
            </li>
        <? endforeach; ?>
    </ul>
</div>
