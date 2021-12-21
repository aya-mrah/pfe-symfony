$(document).ready(function () {


    jQuery.validator.addMethod("emailValidator", function (value, element) {

        var isSuccess = false;

        $.ajax({
            url: Routing.generate('check_email_ajax'),
            method: 'POST',
            data: {email: value},
            async: false,
            success: function (data) {
                if (data.success) {
                    isSuccess = !data.used;
                }
            }
        });
        return isSuccess;

    }, "Cette adresse email est déjà utilisée.");

    $('#jwebi_registration_register').validate({
            rules: {
                'jwebi_user_registration[firstName]': {
                    required: true
                },
                'jwebi_user_registration[lastName]': {
                    required: true
                },
                'jwebi_user_registration[email]': {
                    required: true,
                    email: true,
                    emailValidator: true
                },
                'jwebi_user_registration[plainPassword][first]': {
                    required: true,
                    minlength: 6
                },
                'jwebi_user_registration[plainPassword][second]': {
                    equalTo: "#jwebi_user_registration_plainPassword_first"
                },
                'jwebi_user_registration[cgu]': {
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
                'jwebi_user_registration[firstName]': "Merci de renseigner votre prénom.",
                'jwebi_user_registration[lastName]': "Merci de renseigner votre nom.",
                'jwebi_user_registration[email]': {
                    required: "Merci de renseigner votre adresse e-mail.",
                    email: "Merci de renseigner une adresse e-mail valide."
                },
                'jwebi_user_registration[plainPassword][first]': {
                    required: 'Entrez un mot de passe s\'il vous plait',
                    minlength: 'Le mot de passe est trop court'
                },
                'jwebi_user_registration[plainPassword][second]': 'Les deux mots de passe ne sont pas identiques',
                'jwebi_user_registration[cgu]': "Merci d'accepter les CGU."
            }
        }
    );

    $('#Popin-CGU').on('click', function (e) {
        e.preventDefault();
        $('.Popin_CGU_modal').show();
    });
    $('.CloseModelBtnCGU').on('click', function (e) {
        e.preventDefault();
        $('.Popin_CGU_modal').hide();
    });

});