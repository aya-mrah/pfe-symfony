/**
 * Created by hatem on 01/08/16.
 */
$(document).ready(function () {
 // delete cockies modal //
    $('#impliedsubmit').on('click',function(){
        createCookie('jwebi_coockiespopup',356);
        $("#jwebi-cookiesdirective").remove();
    });
    // end //
    if ($(".styleDate").length) {
        $(".styleDate").datepicker({
            onSelect: function () {
                if ($("#register-trip-form").length)
                    $("#register-trip-form").valid();
            }
        });
    }
    $('#header-login').on('click', function (e) {
        e.preventDefault();
        Modal.show('.login-modal')
    });
    $('#header-register').on('click', function (e) {
        e.preventDefault();
        Modal.show('.register-modal')
    });
    $('#login-register-modal').on('click', function (e) {
        e.preventDefault();
        Modal.show('.register-modal')
    });
    $('#register-login-modal').on('click', function (e) {
        e.preventDefault();
        Modal.show('.login-modal')
    });
    if ($('#Popin-CGU').length) {
        $('#Popin-CGU').on('click', function (e) {
            e.preventDefault();
            // Modal.show(function() {
            $('.Popin_CGU_modal').show();
            // })
        });
    }
    if ($('.CloseModelBtnCGU').length) {
        $('.CloseModelBtnCGU').on('click', function (e) {
            e.preventDefault();
            $('.Popin_CGU_modal').hide();
        });
    }

    if ($('#contactForm').length) {
        $('#contactForm').validate({
                rules: {
                    'contact[prenom]': {
                        required: true
                    },
                    'contact[email]': {
                        required: true,
                        email: true
                    },
                    'contact[msg]': {
                        required: true
                    }
                },
                highlight: function (element) {
                    if (!$(element).hasClass('noValid'))
                        $(element).addClass('noValid');
                },
                unhighlight: function (element) {
                    if ($(element).hasClass('noValid')) {
                        $(element).removeClass('noValid');
                    }
                    $(element).closest('.errorBox').hide()
                },
                errorPlacement: function (error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                        $(placement).closest('.errorBox').show();
                    }
                },
                messages: {
                    'contact[prenom]': "Le prénom est obligatoire.",
                    'contact[msg]': "Le message est obligatoire.",
                    'contact[email]': {
                        required: "L'adresse e-mail obligatoire.",
                        email: "Le format de l'email est incorrect."
                    }
                }
            }
        );
    }
    var createCookie = function(name, value, days) {
        var expires;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        }
        else {
            expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

});
