<?php

defined('_JEXEC') or die;

function rnd($length = 5){
  $chars = 'abdefhiknrstyz';
  $numChars = strlen($chars);
  $string = '';
  for ($i = 0; $i < $length; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
  }
  return $string;
}
$mid = rnd()
?>
<div class="">
<a id="menu<?php echo $mid;?>" class="mobile-menu" href="#"><i class="icon-reorder"></i>МЕНЮ</a>
<ul class="menu<?php echo $class_sfx;?> rmm-menu menu<?php echo $mid;?>"<?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $i => &$item) :
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (in_array($item->id, $path)) {
		$class .= ' active';
	}
	elseif ($item->type == 'alias') {
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path)-1]) {
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path)) {
			$class .= ' alias-parent-active';
		}
	}

	if ($item->deeper) {
		$class .= ' deeper';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}

	echo '<li'.$class.'>';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
			require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper) {
		echo '<ul>';
	}
	// The next item is shallower.
	elseif ($item->shallower) {
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}
endforeach;
?></ul></div>

<script>
$(document).ready(function() {
	var touch 	= $('#menu<?php echo $mid;?>');
	var menu 	= $('.menu<?php echo $mid;?>');
 
	$(touch).on('click', function(e) {
		e.preventDefault();
		menu.slideToggle();
	});
	
	$(window).resize(function(){
		var w = $(window).width();
		if(w > 767 && menu.is(':hidden')) {
			menu.removeAttr('style');
		}
	});
});
</script>

<style>
#menu<?php echo $mid;?>{
	text-align:center;
}

@media (max-width: 767px) {
 
.rmm-menu{display:none;}
 
.mobile-menu{display:block;
}

.rmm-menu li ul{ display:block;
}

.rmm-menu li ul{ border:none;}

 
.rmm-menu li ul li a{
	text-align:center;
}

nav{margin:0;
background:none;}
 
.rmm-menu li{display:block;
margin:0;}
 
.rmm-menu li a {background:#ffffff;
color:#797979;
border-top:1px solid #e0e0e0;
border-left:3px solid #ffffff;}
 
.rmm-menu li a:hover, .rmm-menu li:hover > a{
color:#797979;
}
 
/*level 2 and 3 - make same width as all items*/
.rmm-menu ul {display:block;
position:relative;
top:0;
left:0;
width:100%;}
 
.rmm-menu ul ul {left:0;}
 
}/*end media queries*/

</style>
