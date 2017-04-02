<?php
/**
 * @version		$Id: route.php surinder $
 * @package		Slider
 * @subpackage	Helpers
 * @copyright	Copyright (C) 2017 Open Source Matters, Inc. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');

jimport('joomla.application.categories');
/**
 * Slider Component Route Helper
 *
 * @static
 * @package		Slider
 * @subpackage	Helpers

 */
abstract class SliderHelperRoute
{
	protected static $lookup;
	/**
	 * @param	int	The route of the slider
	 */
	public static function getSliderRoute($id, $catid)
	{
		$needles = array(
			'##firstname##'  => array((int) $id)
		);
		//Create the link
		$link = 'index.php?option=com_slider&view=##firstname##&id='. $id;
		if ($catid > 1) {
			$categories = JCategories::getInstance('##Firstname##');
			$category = $categories->get($catid);
			if ($category) {
				$needles['category'] = array_reverse($category->getPath());
				$needles['categories'] = $needles['category'];
				$link .= '&catid='.$catid;
			}
		}

		if ($item = SliderHelperRoute::_findItem($needles)) {
			$link .= '&Itemid='.$item;
		};

		return $link;
	}


	public static function getCategoryRoute($catid)
	{
		$app = JFactory::getApplication();
	    if ($catid instanceof JCategoryNode)
		{
			$id = $catid->id;
			$category = $catid;
		}
		else
		{
			$id = (int) $catid;
		    $options['extension'] = $app->getUserStateFromRequest('filter.extension', 'extension', 'com_slider.##firstname##');	
			$options['table'] = $app->getUserStateFromRequest('filter.extensiontable', 'extensiontable');
			$category = BookshopCategories::getInstance('Slider',$options)->get($id);
		}

		if($id < 1)
		{
			$link = '';
		}
		else
		{
			$needles = array(
				'category' => array($id)
			);

			if ($item = self::_findItem($needles))
			{
				$link = 'index.php?Itemid='.$item;
			}
			else
			{
				//Create the link
				$link = 'index.php?option=com_slider&view=category&id='.$id;
				if($category)
				{
					$catids = array_reverse($category->getPath());
					$needles = array(
						'category' => $catids,
						'categories' => $catids
					);
					if ($item = self::_findItem($needles)) {
						$link .= '&Itemid='.$item;
					}
					elseif ($item = self::_findItem()) {
						$link .= '&Itemid='.$item;
					}
				}
			}
		}

		return $link;
	}
	
	protected static function _findItem($needles)
	{
		// Prepare the reverse lookup array.
		if (self::$lookup === null) {
			self::$lookup = array();

			$component	= JComponentHelper::getComponent('com_slider');
			$menus		= JApplication::getMenu('site');
			$field = 'component_id';
			$items		= $menus->getItems($field, $component->id);
			foreach ($items as $item) {
				if (isset($item->query) && isset($item->query['view'])) {
					$view = $item->query['view'];
					if (!isset(self::$lookup[$view])) {
						self::$lookup[$view] = array();
					}
					if (isset($item->query['id'])) {
						self::$lookup[$view][$item->query['id']] = $item->id;
					}
				}
			}
		}
		foreach ($needles as $view => $ids) {
			if (isset(self::$lookup[$view])) {
				
				foreach ($ids as $id) {
					if (isset(self::$lookup[$view][(int)$id])) {
						return self::$lookup[$view][(int)$id];
					}
				}
			}
		}

		return null;
	}
}
