<footer class="py-5 bg-dark footer-main">
    <div class="container">
        <!--<div class="row ftop">
            <div class="col-md-3">
                <h4>Learn More</h4>
                <ul>
                    <li><a href="#">How to sell fast</a></li>
                    <li><a href="#">ikman compare</a></li>
                    <li><a href="#">Membership</a></li>
                    <li><a href="#">Banner Advertising</a></li>
                    <li><a href="#">Promote your ad</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>Help & Support</h4>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Stay safe on ikman.lk</a></li>
                    <li><a href="#">Contact us</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>Social</h4>
                <ul>

                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">You Tube</a></li>
                    <li><a href="#">Google+</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>About Us</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Career</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Sitemap</a></li>
                </ul>
            </div>
        </div>-->
        <div class="row fbot">
            <div class="col-md-12">
                <hr class="line">
            </div>

            <div class="col-md-6 fbot-left">
                <p>Copyright &copy; selfee.lk <?php echo date("Y"); ?></p>
            </div>
            <div class="col-md-6 fbot-right">
                <img src="images/logo.png" class="img-fluid" alt="Responsive image">
            </div>
        </div>   
    </div>
    <!-- /.container -->
</footer>

<meta name="_token" content="<?php echo csrf_token(); ?>" />
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo asset('js/app.js'); ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/bootstrap.bundle.js'); ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/lightslider.js'); ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/side-bar.js'); ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/custom.js'); ?>"></script>

<!-- Create Form -->
<script>

    $(document).ready(function(){
        
        /* 
        ******************* 
            IMAGE UPLOAD 
        ******************
        */

        var id = 1;
        var inpId = id;

        var _URL = window.URL || window.webkitURL;
        
        /* show add another image button when previous image uploaded */
        $('div.input-files').on('change', 'input:file', function (e) {

            var showId = ++id;
            var prevId = showId -1;

            // Gets the number of elements with class pn
            var numItems = $('.upimg').length
            
            if(numItems <=5)
            {
                //$(".input-files").append('<div class="row mb-3 upimg img-'+showId+'"><div class="col-lg-4"><div id="uploadPreview-'+showId+'" class="prev-img"></div></div><div class="col-lg-8"><label for="file-upload" class="custom-file-upload" id="file-up-btn-'+showId+'">Add a Photo</label><input type="file" name="file_upload[]"></div><a href="javascript:void(0);" id="remove-'+showId+'" class="remImg" style="display:none;">Remove</a></div>');
                $("#file-up-btn-"+prevId).hide();
                $("#remove-"+prevId).show();
                $("#addAnother").show();
                //alert(numItems+"!");
                
            }

            /* image preview */
            var image, file;
            if ((file = this.files[0])) {
                image = new Image();
                image.onload = function() {
                    src = this.src;
                $('#uploadPreview-'+prevId).html('<img src="'+ src +'"></div>');
                    e.preventDefault();
                }
            };
            image.src = _URL.createObjectURL(file);
            //alert(prevId);
            /* .image preview */

            if(numItems == 5){
                $("#file-up-btn-"+numItems).hide();
                $("#remove-"+numItems).show();
                $("#addAnother").hide();
            }

        });

        $("#addAnother").on('click', '.addImg', function () {
            
            var showId = id;
            var prevId = showId -1;
            // Gets the number of elements with class pn
            var numItems = $('.upimg').length

            $("#addAnother").hide(); 
            $(".input-files").append('<div class="row m-3 p-2 upimg img-'+showId+'"><div class="col-lg-4"><div id="uploadPreview-'+showId+'" class="prev-img"></div></div><div class="col-lg-8"><label for="file-upload" class="custom-file-upload" id="file-up-btn-'+showId+'">Add a Photo</label><input type="file" name="file_upload[]"></div><a href="javascript:void(0);" id="remove-'+showId+'" class="remImg" style="display:none;"><i class="fa fa-minus-circle remove-num" aria-hidden="true"></i> Delete Image</a></div>');
            $("#addAnother").hide();
            if(numItems <=5)
            {
                $("#file-up-btn-"+prevId).hide();
                $("#remove-"+prevId).show();
            }
        });

        $(".input-files").on('click', '.remImg', function () {

            var showId = id;
            var prevId = showId -1;
            // Gets the number of elements with class pn
            var numItems = $('.upimg').length

            if(numItems <=5)
            {
                /*$("#file-up-btn-"+prevId).hide();
                $("#remove-"+prevId).show();*/
                //$("#remove-4").hide();
                $("#addAnother").show();   
            }
            $("#" + $(this).attr("id")).parent().remove();

        });

        

        /* 
        **********************************************
            ADD MULTIPLE PHONE NUMBERS DYNAMILCALLY
        **********************************************
        */
        //Get
        var pid = $('#phone_count').val(); //current number of elements

        if(pid == 5){ $("#dp").hide(); } // hide "add another number" link when phone neumber count is 5

        $(".pno-add").on('click', '.addPhone', function () {
            
            var showPid = ++pid;

            // Gets the number of elements with class pn
            var numItems = $('.p-no').length

            if(numItems <=4)
            {
                $(".phone-numbers").append('<p class="p-no p-no-'+showPid+'"><input type="text" name="phone_number[]" id="phone_number-'+showPid+'" placeholder=" ..."> </p>');
                $("#dp").hide();
            }

            //Dont Show add more button when you have 5 numbers
            if(numItems == 5){
                $("#dp").hide();
            }

            /*Phone number validation */
            $(document).on('keyup', ".p-no-"+showPid+" input[type='text']",function () {
                this.value = this.value.replace(/[^0-9\.]/g,''); //dont allow to type non numeric characters
                var phonenum = $("#phone_number-"+showPid).val();
                if(phonenum.length == 10)
                {
                    $("#pno-message").html("");
                    $("#sbmtPhone").show();
                }
                else {
                    $("#pno-message").html("Phone Number should be 10 digits");
                    $("#sbmtPhone").hide();
                }
            });

            /*Submit the phone number*/
            $(".phone-no-box").one('click', "#sbmtPhone",function () { //only excecute once for one input field
                $("#sbmtPhone").hide(); //hide "Add this number" link
                $("#pno-message").html("");
                $("#phone_number-"+showPid).attr('readonly', true); //make textbox readonly
                $("#phone_number-"+showPid).addClass("phone-nums"); //add phone-nums class
                $(".p-no-"+showPid).append('<a href="javascript:void(0);" id="phone-remove-'+showPid+'" class="phone-remove"><i class="fa fa-minus-circle remove-num" aria-hidden="true"></i></a>');
                if(numItems <= 3){
                    $("#dp").show();
                }
                else{
                    /*$("#addPhone").hide();
                    $(".pno-add").hide();*/
                }
            });

            //remove dynamically added phone numbers
            $(".p-no-"+showPid).on('click', ".phone-remove",function () {
                $("#" + $(this).attr("id")).parent().remove();
                $("#dp").show();
            });

        });

        //remove normal phone numbers
        $(".phone-remove").click(function() {

            var numItems = $('.p-no').length

            $("#" + $(this).attr("id")).parent().remove();
            if(numItems <= 5){
                $("#dp").show();
            }
        });
    
    });

</script>

<!-- Light Slider --> 
<script>
    $(document).ready(function () {
        $("#content-slider").lightSlider({
            loop: true,
            keyPress: true
        });
        $('#image-gallery').lightSlider({
            gallery: true,
            item: 1,
            thumbItem: 9,
            slideMargin: 0,
            speed: 1000,
            auto: false,
            loop: true,
            onSliderLoad: function () {
                $('#image-gallery').removeClass('cS-hidden');
            }
        });
    });
</script>

<!-- Edit Form -->
<script>
    
$(document).ready(function(){
    /* 
    **********************************************
        ADD MULTIPLE PHONE NUMBERS DYNAMILCALLY
    **********************************************
    */
    var pid = $('#e_phone_count').val(); //current number of elements

    if(pid == 5){ $("#e_dp").hide(); } // hide "add another number" link when phone neumber count is 5

    $(".e_pno-add").on('click', '.e_addPhone', function () {
        
        var showPid = ++pid;

        // Gets the number of elements with class pn
        var numItems = $('.p-no').length

        if(numItems <=4)
        {
            $(".e_phone-numbers").append('<p class="p-no e_p-no-'+showPid+'"><input type="text" name="e_phone_number[]" id="e_phone_number-'+showPid+'" placeholder=" ..."> </p>');
            $("#e_dp").hide();
        }

        //Dont Show add more button when you have 5 numbers
        if(numItems == 5){
            $("#e_dp").hide();
        }

        /*Phone number validation */
        $(document).on('keyup', ".e_p-no-"+showPid+" input[type='text']",function () {
            this.value = this.value.replace(/[^0-9\.]/g,''); //dont allow to type non numeric characters
            var phonenum = $("#e_phone_number-"+showPid).val();
            if(phonenum.length == 10)
            {
                $("#e_pno-message").html("");
                $("#e_sbmtPhone").show();
            }
            else {
                $("#e_pno-message").html("Phone Number should be 10 digits");
                $("#e_sbmtPhone").hide();
            }
        });

        $(".phone-no-box").one('click', "#e_sbmtPhone",function () { //only excecute once for one input field
            $("#e_sbmtPhone").hide(); //hide "Add this number" link
            $("#e_pno-message").html("");
            $("#e_phone_number-"+showPid).attr('readonly', true); //make textbox readonly
            $("#e_phone_number-"+showPid).addClass("phone-nums"); //add phone-nums class
            $(".e_p-no-"+showPid).append('<a href="javascript:void(0);" id="e_phone-remove-'+showPid+'" class="e_phone-remove"><i class="fa fa-minus-circle e_remove-num" aria-hidden="true"></i></a>');
            if(numItems <= 3){
                $("#e_dp").show();
            }
        });

        //remove dynamically added phone numbers
        $(".e_p-no-"+showPid).on('click', ".e_phone-remove",function () {
            $("#" + $(this).attr("id")).parent().remove();
            $("#e_dp").show();
            alert('h00i');
        });

    });

    //remove normal phone numbers
    $(".e_phone-remove").click(function() {
        $("#" + $(this).attr("id")).parent().remove();
        $("#e_dp").show();
        alert('removed');
    });

    /* 
    ******************* 
        IMAGE UPLOAD 
    ******************
    */

    //var id = 1;
    var id = $('#e_phone_count').val(); //current number of elements
    var _URL = window.URL || window.webkitURL;
    
    /* show add another image button when previous image uploaded */
    $('div.input-files').on('change', 'input:file', function (e) {

        var showId = ++id;
        var prevId = showId -1; 
        // Gets the number of elements with class pn
        var numItems = $('.upimg').length
        
        if(numItems <=5)
        {
            $("#edit-file-up-btn-"+prevId).hide();
            $("#editRemove-"+prevId).show();
            $("#editAddAnother").show();    
        }

        /* image preview */
        var image, file;
        if ((file = this.files[0])) {
            image = new Image();
            image.onload = function() {
                src = this.src;
            $('#editUploadPreview-'+prevId).html('<img class="img-fluid" src="'+ src +'"></div>');
                e.preventDefault();
            }
        };
        image.src = _URL.createObjectURL(file);
        /* .image preview */

        if(numItems == 5){
            $("#edit-file-up-btn-"+numItems).hide();
            $("#editRemove-"+numItems).show();
            $("#editAddAnother").hide();
        }

    });

    $("#editAddAnother").on('click', '.addImg', function () {
        
        var showId = id;
        var prevId = showId -1;
        // Gets the number of elements with class pn
        var numItems = $('.upimg').length

        $("#editAddAnother").hide(); 
        $(".input-files").append('<div class="row m-3 p-3 upimg img-'+showId+'"><div class="col-lg-4"><div id="editUploadPreview-'+showId+'" class="prev-img"></div></div><div class="col-lg-8"><label for="file-upload" class="custom-file-upload" id="edit-file-up-btn-'+showId+'">Add a Photo</label><input type="file" name="file_upload[]"></div><a href="javascript:void(0);" id="editRemove-'+showId+'" class="remImg" style="display:none;"><i class="fa fa-minus-circle remove-num" aria-hidden="true"></i> Delete Image</a></div>');
        if(numItems <=5)
        {
            $("#edit-file-up-btn-"+prevId).hide();
            $("#editRemove-"+prevId).show();
        }
    });

    $(".input-files").on('click', '.remImg', function () {

        var showId = id;
        var prevId = showId -1;
        // Gets the number of elements with class pn
        var numItems = $('.upimg').length

        alert('numItems' + numItems);

        if(numItems <=5)
        {
            $("#editAddAnother").show();   
        }
        $("#" + $(this).attr("id")).parent().remove();
    });

    //remove normal phone numbers
    $(".edit-img-preview").on('click', '.remImg', function () {
        var numItems = $('.upimg').length
        $("#" + $(this).attr("id")).parent().remove();
        if(numItems <=5){
            $("#editAddAnother").show();
        }
    });

});

</script>

