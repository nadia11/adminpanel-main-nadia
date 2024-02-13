$(document).ready(function (){
    var windowHeight = $( window ).outerHeight();
    var divHeight = $( '.divCenter' ).outerHeight();
    var MarginTop = 20+( windowHeight - divHeight) / 2;

    $(".divCenter").css('margin-top', MarginTop +'px');




    //show file name on label bootstrap4
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $(this).siblings('.custom-file-label').html( fileName );
    });

}); // Document Ready Function



$(document).ready(function (){
    /********Restriction for Date patern********/
    $('input[type="datetime"]').attr('patern', 'pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}"');

    $('input[type="datetime"]').datepicker({
        showButtonPanel: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        gotoCurrent : true,
        hideIfNoPrevNext: true,
        closeText: "Done",
        currentText: "Today",
        prevText:"Prev",
        nextText:"Next",
        firstDay: 6,  //6: "Saturday", 0: "Sunday",
        dayNamesMin: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],

        isRTL: false,
        showOptions: { direction: "up" },
        dateFormat: "dd/mm/yy",
        showAnim: "slideDown", duration: "fast", //fold, slideDown, fadeIn
        buttonImageOnly: true, showOn: "button", buttonImage: "" + tits_project.url + "/images/calendar.png", buttonText: "Date selector"
    });
    $.datepicker._gotoToday = function(id) { $(id).datepicker('setDate', new Date()).datepicker('hide').focus(); }; //.blur(); if button selector not active
}); // Document Ready Function

$(document).ready(function(){

    //var protocol = window.location.protocol;
    //var hostname = window.location.hostname;
    //var domain_name = window.location.href.split('/')[3];
    //var projectUrl = protocol + '//' + hostname + '/';
    //var projectUrl = protocol + '//' + hloginostname + '/' + domain_name;

    /* Fullscreen background */
    $.backstretch([
        tits_project.url + "/frontend/images/bg/1.jpg",
        tits_project.url + "/frontend/images/bg/2.jpg",
        tits_project.url + "/frontend/images/bg/3.jpg",
        tits_project.url + "/frontend/images/bg/4.jpg",
        tits_project.url + "/frontend/images/bg/5.jpg",
        tits_project.url + "/frontend/images/bg/6.jpg",
    ], {duration: 3000, fade: 750});

}); // Document Ready Function



(function ($) {
    $('.member_search_by').on('click', 'label#by_bmdc_reg', function(){
        $(".by_bmdc_reg_field").slideDown().find('input#bmdc_reg').attr('required', 'required').removeAttr('disabled');
        $(".by_name_field").slideUp().find('input#member_name').removeAttr('required').attr('disabled', 'disabled');
        $(".by_mobile_field").slideUp().find('input#mobile').removeAttr('required').attr('disabled', 'disabled');
    });
    $('.member_search_by').on('click', 'label#by_name', function(){
        $(".by_bmdc_reg_field").slideUp().find('input#bmdc_reg').removeAttr('required').attr('disabled', 'disabled');
        $(".by_name_field").slideDown().find('input#member_name').attr('required', 'required').removeAttr('disabled');
        $(".by_mobile_field").slideUp().find('input#mobile').removeAttr('required').attr('disabled', 'disabled');
    });
    $('.member_search_by').on('click', 'label#by_mobile', function(){
        $(".by_bmdc_reg_field").slideUp().find('input#bmdc_reg').removeAttr('required').attr('disabled', 'disabled');
        $(".by_name_field").slideUp().find('input#member_name').removeAttr('required').attr('disabled', 'disabled');
        $(".by_mobile_field").slideDown().find('input#mobile').attr('required', 'required').removeAttr('disabled');
    });
})(jQuery);




(function ($) {
    $(document).on("click", 'button.show_password', function(e) {
        e.preventDefault();

        var form = $(this).parents('form').attr('id');

        $(this).toggleClass("btn-danger active");
        $(this).find("i").toggleClass("fa-eye-slash");

        if( $(this).hasClass("active") ){
            $('#'+form).find("input:password").attr("type", "text");
        }else{
            $('#'+form).find("input#old_password").attr("type", "password");
            $('#'+form).find("input#password").attr("type", "password");
            $('#'+form).find("input#confirm_password").attr("type", "password");
        }
    });

    $(".gen_password_member").on('click', function(){
        var form = $(this).parents('form').attr('id');

        var charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
        var password = '';

        for(var i = 0; i < 18; i++){
            var random_position = Math.floor(Math.random() * charset.length);
            password += charset[random_position];
        }
        password = password.replace(/</g, "&lt;").replace(/>/g, "&gt;");

        $('#'+form).find('#password, #confirm_password').val( password );
        $('#'+form).find('#password').focus().blur();
    });

    $("#confirm_password").focus(function(){
        $(this).parents('.form-group').append('<span class="matchPassword"></span>');
        $(this).keyup(function(){
            if($('#password').val() != $("#confirm_password").val() ){
                $(".matchPassword").removeClass('text-success').addClass("text-danger");
                $(".matchPassword").text("Passwords Don't Match!");
            }else{
                $(".matchPassword").removeClass('text-danger').addClass("text-success");
                $(".matchPassword").text("Passwords Matched");
            }
        });
    });
    $("#confirm_password").blur(function(){
        $(".matchPassword").remove();
    });
})(jQuery);

