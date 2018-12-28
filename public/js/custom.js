$(document).ready(function() {
    
    $('select[name="customer_locations"]').on('change', function(){
        var location_name = $(this).val();
        if(location_name) {
            $.ajax({
                url: '/sub_locations/get/'+location_name,
                type:"GET",
                dataType:"json",
                beforeSend: function(){
                    $('#loader').css("visibility", "visible");
                },
                success:function(data) {
                    $('select[name="customer_sub_locations"]').empty();
                    $.each(data, function(key, value){
                        $('select[name="customer_sub_locations"]').append('<option value="'+ value +'">' + value + '</option>');
                    });
                },
                complete: function(){
                    $('#loader').css("visibility", "hidden");
                }
            });
        }
        else {
            $('select[name="customer_sub_locations"]').empty();
        }

    });
    
});

$(document).ready(function(){
    /*$("#main").submit(function(e) {
        //e.preventDefault();
        $("#phones").show();
    });*/
    $('#showPhone').click(function() {
        $('#phones').toggle('fast', function() {
            // Animation complete.
        });
        $("#showPhone").hide();
    });
});

/*$(document).ready(function () {
    $('.all-locations li:gt(3)').hide();
    $('#loadMoreLocations').click(function() {
        $('.all-locations li:gt(3)').show();
        $('#loadMoreLocations').hide();
    });
});*/