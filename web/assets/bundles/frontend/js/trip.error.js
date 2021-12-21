$(document).ready(function () {

    jQuery.validator.addMethod("greaterThan", function (value, element, params) {

        val = value.split('/');
        par = $(params).val().split('/');

        var inputDate = new Date(val[2], val[1] - 1, val[0]);
        var paramDate = new Date(par[2], par[1] - 1, par[0]);

        return inputDate.setHours(0, 0, 0, 0) >= paramDate.setHours(0, 0, 0, 0);

    }, 'La date doit être supérieure à la date de départ.');

    jQuery.validator.addMethod("greaterThanNow", function (value, element, params) {

        val = value.split('/');

        var inputDate = new Date(val[2], val[1] - 1, val[0]);
        var paramDate = new Date();

        return inputDate.setHours(0, 0, 0, 0) >= paramDate.setHours(0, 0, 0, 0);

    }, 'La date doit être dans le futur.');

    jQuery.validator.addMethod("requiredWhen", function (value, element, params) {
        if ($('#allerSimple').val() == 1) {
            return true;
        }
        if (value) {
            return true;
        } else {
            return false;
        }
    }, 'La date de retour est obligatoire.');

    $('#register-trip-form').validate({
            rules: {
                'trip[from]': {
                    required: true
                },
                'trip[to]': {
                    required: true
                },
                'trip[start_date]': {
                    required: true,
                    greaterThanNow: true
                },
                'trip[end_date]': {
                    requiredWhen: true,
                    greaterThan: '#trip_start_date'
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
                'trip[from]': "La ville de départ est obligatoire.",
                'trip[to]': "La ville d'arrivée est obligatoire.",
                'trip[start_date]': {
                    required: "La date d'aller est obligatoire."
                }
            }
        }
    );

});