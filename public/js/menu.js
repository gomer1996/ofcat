$(document).ready(function() {
    $('.catalog_menu a.catalog_menu_link').click(function(e){     
        if ($('.catalog_menu').hasClass('active')) {
            $('.catalog_menu>.catalog_menu_dropdown').slideUp();
            $('.catalog_menu').removeClass('active');
        } else {
            $('.catalog_menu>.catalog_menu_dropdown').slideDown();
            $('.catalog_menu').addClass('active');
        }   
        
    });
    $(document).mouseup(function (e){ 
        var div = $(".catalog_menu_link"); 
        var div1 = $(".catalog_menu_dropdown"); 
        if (!div.is(e.target) && !div1.is(e.target) && div.has(e.target).length === 0  && div1.has(e.target).length === 0) { // и не по его дочерним элементам
            $('.catalog_menu>.catalog_menu_dropdown').slideUp();
            $('.catalog_menu').removeClass('active');
        }
    });
});