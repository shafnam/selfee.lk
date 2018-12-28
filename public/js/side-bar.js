$(document).ready(function(){
    $('ul.category-list li.active .sub-menu').css('display','block');
    $('ul.category-list li.hide .sub-menu').css('display','none');
    $('ul.category-list li.hideactive .sub-menu').css('display','block');
    $('ul.category-list li.hideactive .sub-menu li').css('display','none');
    $('ul.category-list li.hideactive .sub-menu li.active').css('display','block');

    $('ul.location-list li.active .sub-menu').css('display','block');
    $('ul.location-list li.hide .sub-menu').css('display','none');
    $('ul.location-list li.hideactive .sub-menu').css('display','block');
    $('ul.location-list li.hideactive .sub-menu li').css('display','none');
    $('ul.location-list li.hideactive .sub-menu li.active').css('display','block');
    
    $('.hide').css('display','none');

    if($('#price_min').val() || $('#price_max').val()){
        $('#priceFilter').addClass( "show" );
    }

    if ($("input[name='ad_condition']:checked").val()) {
        $('#conditionFilter').addClass( "show" );
    }

    if ($("input[name='ad_brand']:checked").val()) {
        $('#brandFilter').addClass( "show" );
    }
});

$(document).ready(function () {
    //$('#locationsList').css('display','none');
    $('.location-list li:gt(15)').hide();
    $('#loadMore').click(function() {
        $('.location-list li:gt(15)').show();
        $('#loadMore').hide();
    });
});

$(document).ready(function () {
    $('.accordion-toggle').click(function() {
        //$('.accordion-body').toggle('1000');
        $("i", this).toggleClass("fa fa-angle-up fa fa-angle-down");
    });
});
    