$(document).ready(function(){
    $('#location_name').focusout(function(){
        var slug = $('#location_slug').val();
        var name = $('#location_name').val();
        $('#location_submit_btn').attr("disabled", "disabled");
        checkSlug(name,slug,1);

    });
    $('#location_slug').focusout(function(){
        var slug = $('#location_slug').val();
        var name = $('#location_name').val();
        $('#location_submit_btn').attr("disabled", "disabled");
        checkSlug(name,slug,1);
    });
    $('#category_name').focusout(function(){
        var slug = $('#category_slug').val();
        var name = $('#category_name').val();
        $('#category_submit_btn').attr("disabled", "disabled");
        checkSlug(name,slug,2);

    });
    $('#category_slug').focusout(function(){
        var slug = $('#category_slug').val();
        var name = $('#category_name').val();
        $('#category_submit_btn').attr("disabled", "disabled");
        checkSlug(name,slug,2);
    });
    $('#get_sub_location_table').DataTable({
        "order": [[ 2, "asc" ]]
    });
    $('#get_sub_category_table').DataTable({});
    $('#get_location_table').DataTable({});
    $('#get_category_table').DataTable({});
    $('#parent_location').select2();
    $('#parent_category').select2();
});

function checkSlug(name,slug,id){
    var baseUrl = document.location.origin;
    if(id ==1){
        $.ajax({
            url: baseUrl+'/administrator/location_slug',
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {name:name,slug:slug},
            success: function(data){                
                $('#location_slug').val(data);
                $('#location_submit_btn').removeAttr('disabled');  
            }
        });
    }
    else{
        $.ajax({
            url: baseUrl+'/administrator/category_slug',
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {name:name,slug:slug},
            success: function(data){
                $('#category_slug').val(data);
                $('#category_submit_btn').removeAttr('disabled');
            }
        });
    }
}