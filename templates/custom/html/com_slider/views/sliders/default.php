
<?php 
foreach($this->items as $item){ ?>

	<tr>

		<td>
			<a href="index.php?option=com_slider&view=sliders&id=<?php echo $item->id; ?>">
				<?php
				echo $item->description;
				?>
			</a>
		</td>
		<td><?php echo $item->image; ?></td>
		<td><?php echo $item->old_price; ?></td>
		<td><?php echo $item->new_price; ?></td>
		<td><?php echo $item->published; ?></td>
		<td><?php echo $item->ordering; ?></td>
		<td><a href="<?php echo JRoute::_('index.php?option=com_slider&view=sliders&layout=edit&id='.$item->id); ?>" class="btn"><?php echo JText::_('COM_SLIDER_BUTTON_EDIT'); ?></a></td>
	</tr>
<?php } ?>


<div class="slider">
	<ul class="bxslider">
		<li><img src="assets/images/slider-img.png">
			<div class="container">
				<div id="advertising" class="fsize-33 col-sm-7 col-lg-7 col-xs-12">
					Набор (6 шт) пластиковых брекетов
					Elegance Roth 018

					<div class="prices margin-top-40">
						<span class="tahoma">7 999 руб</span> <span
							class="margin-left-30 font-red fsize-40">5 000 руб</span>
					</div>
				</div>
			</div>
		</li>
		<li><img src="assets/images/slider-img.png">
			<div class="container">
				<div id="advertising" class="fsize-33 col-sm-7 col-lg-7 col-xs-12">
					Набор (6 шт) пластиковых брекетов
					Elegance Roth 018

					<div class="prices margin-top-40">
						<span class="tahoma">7 999 руб</span> <span
							class="margin-left-30 font-red fsize-40">5 000 руб</span>
					</div>
				</div>
			</div>
		</li>
		<li><img src="assets/images/slider-img.png">
			<div class="container">
				<div id="advertising" class="fsize-33 col-sm-7 col-lg-7 col-xs-12">
					Набор (6 шт) пластиковых брекетов
					Elegance Roth 018

					<div class="prices margin-top-40">
						<span class="tahoma">7 999 руб</span> <span
							class="margin-left-30 font-red fsize-40">5 000 руб</span>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>