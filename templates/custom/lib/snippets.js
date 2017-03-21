//Плавный скролл к верху страницы
$("a[href='#top']").click(function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
});

//Дублирование thead в самый низ html таблицы
var $tfoot = $('<tfoot></tfoot>');
$($('thead').clone(true, true).children().get().reverse()).each(function() {
    $tfoot.append($(this));
});
$tfoot.insertAfter('table thead');

//Загрузка внешнего контента
$("#content").load("somefile.html", function(response, status, xhr) {
    // error handling
    if(status == "error") {
        $("#content").html("An error occured: " + xhr.status + " " + xhr.statusText);
    }
});

//Колонки одинаковой высоты
var maxheight = 0;
$("div.col").each(function() {
    if($(this).height() > maxheight) { maxheight = $(this).height(); }
});

$("div.col").height(maxheight);

//Табличные полосы (зебра)
$(document).ready(function(){
    $("table tr:even").addClass('stripe');
});

//Частичное обновление страницы
setInterval(function() {
    $("#refresh").load(location.href+" #refresh>*","");
}, 10000); // milliseconds to wait

//редзагрузка изображений
$.preloadImages = function() {
    for(var i = 0; i<arguments.length; i++) {
        $("<img />").attr("src", arguments[i]);
    }
}

$(document).ready(function() {
    $.preloadImages("hoverimage1.jpg","hoverimage2.jpg");
});

//Открытие внешних ссылок в новом окне или новой вкладке
$('a').each(function() {
    var a = new RegExp('/' + window.location.host + '/');
    if(!a.test(this.href)) {
        $(this).click(function(event) {
            event.preventDefault();
            event.stopPropagation();
            window.open(this.href, '_blank');
        });
    }
});

//Div по ширине/высоте вьюпорта
// global vars
var winWidth = $(window).width();
var winHeight = $(window).height();

// set initial div height / width
$('div').css({
    'width': winWidth,
    'height': winHeight,
});

// make sure div stays full width/height on resize
$(window).resize(function(){
    $('div').css({
        'width': winWidth,
        'height': winHeight,
    });
});

//Проверка сложности пароля
<input type="password" name="pass" id="pass" />
<span id="passstrength"></span>

        $('#pass').keyup(function(e) {
            var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
            var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
            var enoughRegex = new RegExp("(?=.{6,}).*", "g");
            if (false == enoughRegex.test($(this).val())) {
                $('#passstrength').html('More Characters');
            } else if (strongRegex.test($(this).val())) {
                $('#passstrength').className = 'ok';
                $('#passstrength').html('Strong!');
            } else if (mediumRegex.test($(this).val())) {
                $('#passstrength').className = 'alert';
                $('#passstrength').html('Medium!');
            } else {
                $('#passstrength').className = 'error';
                $('#passstrength').html('Weak!');
            }
            return true;
        });

//зменение размеров изображения
$(window).bind("load", function() {
    // IMAGE RESIZE
    $('#product_cat_list img').each(function() {
        var maxWidth = 120;
        var maxHeight = 120;
        var ratio = 0;
        var width = $(this).width();
        var height = $(this).height();

        if(width > maxWidth){
            ratio = maxWidth / width;
            $(this).css("width", maxWidth);
            $(this).css("height", height * ratio);
            height = height * ratio;
        }
        var width = $(this).width();
        var height = $(this).height();
        if(height > maxHeight){
            ratio = maxHeight / height;
            $(this).css("height", maxHeight);
            $(this).css("width", width * ratio);
            width = width * ratio;
        }
    });
    //$("#contentpage img").show();
    // IMAGE RESIZE
});

//Автоматическая загрузка контента по скроллу
var loading = false;
$(window).scroll(function(){
    if((($(window).scrollTop()+$(window).height())+250)>=$(document).height()){
        if(loading == false){
            loading = true;
            $('#loadingbar').css("display","block");
            $.get("load.php?start="+$('#loaded_max').val(), function(loaded){
                $('body').append(loaded);
                $('#loaded_max').val(parseInt($('#loaded_max').val())+50);
                $('#loadingbar').css("display","none");
                loading = false;
            });
        }
    }
});

$(document).ready(function() {
    $('#loaded_max').val(50);
});

//Проверить, загрузилось ли изображение
var imgsrc = 'img/image1.png';
$('<img/>').load(function () {
    alert('image loaded');
}).error(function () {
    alert('error loading image');
}).attr('src', imgsrc);

//Сортировка списка в алфавитном порядке
$(function() {
    $.fn.sortList = function() {
        var mylist = $(this);
        var listitems = $('li', mylist).get();
        listitems.sort(function(a, b) {
            var compA = $(a).text().toUpperCase();
            var compB = $(b).text().toUpperCase();
            return (compA < compB) ? -1 : 1;
        });
        $.each(listitems, function(i, itm) {
            mylist.append(itm);
        });
    }

    $("ul#demoOne").sortList();

});


// Создание динамических меню
function makeMenu(items, tags) {

    tags = tags || ['ul', 'li']; // default tags
    var parent = tags[0];
    var child = tags[1];

    var item, value = '';
    for (var i = 0, l = items.length; i < l; i++) {
        item = items[i];
        // Separate item and value if value is present
        if (/:/.test(item)) {
            item = items[i].split(':')[0];
            value = items[i].split(':')[1];
        }
        // Wrap the item in tag
        items[i] = '<' + child + ' ' +
                (value && 'value="' + value + '"') + '>' + // add value if present
                item + '</' + child + '>';
    }
    return '<' + parent + '>' + items.join('') + '</' + parent + '>';
//Применение: 
// Dropdown select month
    makeMenu(
            ['January:JAN', 'February:FEB', 'March:MAR'], // item:value
            ['select', 'option']
    );
// List of groceries
    makeMenu(
            ['Carrots', 'Lettuce', 'Tomatos', 'Milk'],
            ['ol', 'li']
    );
//http://jsbin.com/iyakur/2/edit


//Скрыть или показать элемент
    function showhide(e) {
        el = document.getElementById(e);
        el.style.display = el.style.display == "block" ? "none" : "block";
    }
}

