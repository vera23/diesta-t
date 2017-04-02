<?php
defined('_JEXEC') or die('Restricted access');

function SliderBuildRoute( &$query ) {
	$segments = array();

	if (isset($query['view'])) {
		$segments[0] = $query['view'];
		unset($query['view']);
	};

	if (isset($query['id'])) {
		$segments[1] = $query['id'];
		unset($query['id']);
		if (isset($query['layout'])) {
			$segments[2] = $query['layout'];
			unset($query['layout']);
		};
	}else if (isset($query['layout']) && $query['layout'] == 'edit') {
		$segments[1] = 0;
		$segments[2] = 'edit';
		unset($query['layout']);
	};

	return $segments;
} // End SliderBuildRoute function

function SliderParseRoute( $segments ){
	$vars = array();    
	if (count($segments) > 0) {
		$vars['view'] = $segments[0];
		switch ($vars['view']) {
			case 'all':
				$catid = explode(':', $segments[1]);
				$vars['catid']= (int) $catid[0];
			break;
			case 'category':
				$vars['id']   = (int) $segments[1];
			break;
			case 'sliders':
				if(isset($segments[1])){
			  		$id   = explode(':', $segments[1]);
			  		$vars['id']= (int) $id[0];
			  		if(isset($segments[2])){
				  		$vars['layout'] = $segments[2];
					}
				}
			break;
			case 'help':
				if(isset($segments[1])){
			  		$id   = explode(':', $segments[1]);
			  		$vars['id']= (int) $id[0];
			  		if(isset($segments[2])){
				  		$vars['layout'] = $segments[2];
					}
				}
			break;
			case 'homes':
				if(isset($segments[1])){
			  		$id   = explode(':', $segments[1]);
			  		$vars['id']= (int) $id[0];
			  		if(isset($segments[2])){
				  		$vars['layout'] = $segments[2];
					}
				}
			break;

		};      
	} else {
		$vars['view'] = 'home';
	} // End count(segments) statement

	return $vars;
} // End SliderParseRoute

?>
