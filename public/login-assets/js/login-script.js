$(document).ready(function (){
    //$('input[placeholder]').placeholderLabel();
    //$('.label-placeholder').placeholderLabel();
});

$(document).ready(function (){
    var windowHeight = $( window ).outerHeight();
    var divHeight = $( '.divCenter' ).outerHeight();
    var MarginTop = ( windowHeight - divHeight) / 2;
    
    $(".divCenter").css('margin-top', MarginTop + 'px');
});


$(document).ready(function(){

    //var protocol = window.location.protocol;
    //var hostname = window.location.hostname;
    //var domain_name = window.location.href.split('/')[3];
    //var projectUrl = protocol + '//' + hostname + '/';
    //var projectUrl = protocol + '//' + hloginostname + '/' + domain_name;

    /* Fullscreen background */
    // $.backstretch([
        // tits_project.url + "/login-assets/images/bg/1.jpg",
        // tits_project.url + "/login-assets/images/bg/2.jpg",
        // tits_project.url + "/login-assets/images/bg/3.jpg",
        // tits_project.url + "/login-assets/images/bg/4.jpg",
        // tits_project.url + "/login-assets/images/bg/5.jpg",
        // tits_project.url + "/login-assets/images/bg/6.jpg",
    // ], {duration: 3000, fade: 750});

}); // Document Ready Function



$(document).ready(function(){
        //Password Generator Modal
        $('#gen_password').click(function(){
            $('#gen_password_modal').modal();
        });        
        
        $("#gen_new_pwd").click(function(){
            
            var alpha_lower = $("#alpha_lower").is(':checked') ? $("#alpha_lower").val() : '';
            var alpha_upper = $("#alpha_upper").is(':checked') ? $("#alpha_upper").val() : '';
            var numeric = $("#numeric").is(':checked') ? $("#numeric").val() : '';
            var special = $("#special").is(':checked') ? $("#special").val() : '';
            var charset = alpha_lower + alpha_upper + numeric + special;

            var password = '';
            var password_length = parseInt($('#pwd_length').val());
            
            for(var i = 0; i < password_length; i ++){
                var random_position = Math.floor(Math.random() * charset.length);
                password += charset[random_position];
            }
            if(password.length == password_length){
                password = password.replace(/</g, "&lt;").replace(/>/g, "&gt;");
                $('#gen_pwd_container').val(password);    
            }else{
              console.log(password.length , password_length);
            }
        });
        
        $('#password_copied').click(function(e){
            if( $(this).is(':checked') ){
                $('#use_password').attr({class: "btn btn-success", disabled: "disabled"});
                $('#use_password').prop('disabled',false);
            }else{
                $('#use_password').attr("class", "disabled btn btn-success");
                $('#use_password').attr('disabled',true);
            }
        });
        
        $('#use_password').click(function(){
            $('#password, #confirm_password').val( $('#gen_pwd_container').val() );
            $('#password').focus().blur();
        });
        
        $("#select_n_copy").click(function(){
            $("#gen_pwd_container").focus();
            $("#gen_pwd_container").select();
            document.execCommand('copy');
            
            $( ".coppied_msg" ).text( "Password Copied to clipboard" ).show().fadeOut( 2000 )
        });
        
}); // Document Ready Function



//Password Strength
jQuery(document).ready(function () {
    "use strict";
    var options = {};
    options.ui = {
        container: "#pwd-container",
        showVerdictsInsideProgressBar: true,
        viewports: {
            progress: ".pwstrength_viewport_progress"
        }
    };
    options.common = {
        debug: true,
        onLoad: function () {
            //$('#pwd-container').text('Start typing password');
        }
    };
    $(':password').pwstrength(options);
});



jQuery(document).ready(function () {
    //show hide password on registration form
    $("#show_password").on("click", function(e) {
        e.preventDefault();

        $(this).closest("button").toggleClass("btn-warning");
        $(this).closest("button").find("i").toggleClass("fa-eye-slash");

        var btnText = $(this).closest("button").find("span").text();
        if( btnText == "Show Password" ){
            $(this).closest("button").find("span").text("Hide Password");
            $("input:password").attr("type", "text");
        }else{
            $(this).closest("button").find("span").text("Show Password");
            $("input#password").attr("type", "password");
            $("input#confirm_password").attr("type", "password");
        }
    });
});
