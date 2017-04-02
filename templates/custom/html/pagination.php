<?php
defined( '_JEXEC' ) or die;
/**
 * Код этого файла отвечает за вывод пагинации в шаблон
 */
/*
 * Здесь задается вид кнопок перехода к следующей или к предыдущей записи
 * */
function getArrows()
{
    return [
        'prev' => '&lsaquo;',
        'next' => '&rsaquo;'
    ];
}
/**
 * Вывод пагинации
 *
 * @param   array $list Массив, в котором содержится информация о пагинации
 *
 * @return  string HTML разметка
 *
 * @since   3.0
 */
function pagination_list_render( $list )
{
    // Вычисление необходимого диапазона страниц для показа
    $currentPage = 1;
    $range = 1;
    $step = 5;
    foreach ( $list[ 'pages' ] as $k => $page )
    {
        if ( ! $page[ 'active' ] )
        {
            $currentPage = $k;
        }
    }
    if ( $currentPage >= $step )
    {
        if ( $currentPage % $step == 0 )
        {
            $range = ceil( $currentPage / $step ) + 1;
        } else
        {
            $range = ceil( $currentPage / $step );
        }
    }
    // Начало формирования html-разметки
    $html = '<nav><ul class="pagination">';
    //  $html .= $list[ 'start' ][ 'data' ];
    $html .= $list[ 'previous' ][ 'data' ];
    foreach ( $list[ 'pages' ] as $k => $page )
    {
        if ( in_array( $k, range( $range * $step - ( $step + 1 ), $range * $step ) ) )
        {
            if ( ( $k % $step == 0 || $k == $range * $step - ( $step + 1 ) ) && $k != $currentPage && $k != $range * $step - $step )
            {
                $page[ 'data' ] = preg_replace( '#(<a.*?>).*?(</a>)#', '$1...$2', $page[ 'data' ] );
            }
        }
        $html .= $page[ 'data' ];
    }
    $html .= $list[ 'next' ][ 'data' ];
    //  $html .= $list[ 'end' ][ 'data' ];
    $html .= '</ul></nav>';
    return $html;
}
/**
 * Рендер активного элемента пагинации
 *
 * @param   JPaginationObject $item Текущий объект пагинации
 *
 * @return  string HTML-разметка для активного элемента
 *
 * @since   3.0
 */
function pagination_item_active( &$item )
{
    $arrows = getArrows();
    $class = '';
    // Проверка и формирования элемента "Start"
    /*  if ( $item->text == JText::_( 'JLIB_HTML_START' ) )
      {
            $display = '<span class="icon-first"></span>';
      }*/
    // Проверка и формирования элемента "Prev"
    if ( $item->text == JText::_( 'JPREV' ) )
    {
        $display = '<span class="icon-previous">' . $arrows[ 'prev' ] . '</span>';
    }
    // Проверка и формирования элемента "Next"
    if ( $item->text == JText::_( 'JNEXT' ) )
    {
        $display = '<span class="icon-next">' . $arrows[ 'next' ] . '</span>';
    }
    // Проверка и формирования послденего элемента
    /*if ( $item->text == JText::_( 'JLIB_HTML_END' ) )
    {
          $display = '<span class="icon-last"></span>';
    }*/
    // Если элемент не сформирован, тогда просто формируем его с содержимым текстом
    if ( ! isset( $display ) )
    {
        $display = $item->text;
        //    $class = ' class="hidden-phone"';
    }
    return '<li' . $class . '><a title="' . $item->text . '" href="' . $item->link . '">' . $display . '</a></li>';
}
/**
 * Рендер неактивного элемента
 *
 * @param   JPaginationObject $item Текущий объект пагинации
 *
 * @return  string HTML-разметка для неактивного элемента
 *
 * @since   3.0
 */
function pagination_item_inactive( &$item )
{
    // Проверка и формирования элемента "Start"
    /*if ( $item->text == JText::_( 'JLIB_HTML_START' ) )
    {
      return '<li class="disabled"><a><span class="icon-first"></span></a></li>';
    }*/
    // Проверка и формирования элемента "Prev"
    if ( $item->text == JText::_( 'JPREV' ) )
    {
        return '';
    }
    // Проверка и формирования элемента "Next"
    if ( $item->text == JText::_( 'JNEXT' ) )
    {
        return '';
    }
    // Проверка и формирования послденего элемента
    /*if ( $item->text == JText::_( 'JLIB_HTML_END' ) )
    {
      return '<li class="disabled"><a><span class="icon-last"></span></a></li>';
    }*/
    // Проверка и формирование элемента при условии активной страницы
    if ( isset( $item->active ) && ( $item->active ) )
    {
        return '<li><span class="active">' . $item->text . '</span></li>';
    }
    // Не совпало ни одно из предыдущих условий - выводим обычный элемент
    return '<li><span class="disabled">' . $item->text . '</span></li>';
}
