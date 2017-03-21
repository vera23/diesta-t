<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Slider
 * @author     Miroshnichenko Vera Mikhailovna <veramir10@gmail.com>
 * @copyright  2017 Miroshnichenko Vera Mikhailovna
 * @license    GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;


?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_SLIDER_FORM_LBL_SLIDER_IMAGE'); ?></th>
			<td>
			<?php
			foreach ((array) $this->item->image as $singleFile) : 
				if (!is_array($singleFile)) : 
					$uploadPath = '../images/slider' . DIRECTORY_SEPARATOR . $singleFile;
					 echo '<a href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank">' . $singleFile . '</a> ';
				endif;
			endforeach;
		?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SLIDER_FORM_LBL_SLIDER_DESCRIPTION'); ?></th>
			<td><?php echo nl2br($this->item->description); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SLIDER_FORM_LBL_SLIDER_OLD_PRICE'); ?></th>
			<td><?php echo $this->item->old_price; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SLIDER_FORM_LBL_SLIDER_NEW_PRICE'); ?></th>
			<td><?php echo $this->item->new_price; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SLIDER_FORM_LBL_SLIDER_ACTIVE'); ?></th>
			<td><?php echo $this->item->active; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SLIDER_FORM_LBL_SLIDER_ORDER'); ?></th>
			<td><?php echo $this->item->order; ?></td>
		</tr>

	</table>

</div>

