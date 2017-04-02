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
    <ul id="menu-ul" class="menu nav navbar-nav fsize-18 <?php echo $mid;?>"<?php
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

<!--<script>
    $(document).ready(function() {
        var touch 	= $('#menu<?php /*echo $mid;*/?>');
        var menu 	= $('.menu<?php /*echo $mid;*/?>');

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
-->