$(document).ready(function () {

    var bonus = 5;
    var price = 0;
    var comm = 5;

    function tabChange() {
        var deploc = $('#alert_form_departureLocation').val();
        var arrloc = $('#alert_form_arrivalLocation').val();
        var depdate = $('#alert_form_departureDate').val();
        var datereq = $('#alert_form_date_req').prop('checked');
        $('#alert_form').trigger('reset');
        $('#alert_form_departureLocation').val(deploc);
        $('#alert_form_arrivalLocation').val(arrloc);
        $('#alert_form_departureDate').val(depdate);
        $('#alert_form_date_req').prop('checked', datereq);
    }

    $('#alert_form_option_0').on('click', function () {
        $('div[name="option_send"]').show();
        $('div[name="option_buy"]').hide();
        tabChange();
        $('#alert_form_option_0').prop('checked', true);

    });

    $('#alert_form_option_1').on('click', function () {
        $('div[name="option_buy"]').show();
        $('div[name="option_send"]').hide();
        tabChange();
        $('#alert_form_option_1').prop('checked', true);

    });


    $('#alert_form_attachments').MultiFile({
        list: '#alert_att_list',
        STRING: {
            file: '<ul style="display: inline;" title="Click to remove" onclick="$(this).parent().prev().click()">$file</ul>',
            remove: '<a href="#" class="isIcon delete"></a>'
        }
    });

    var regexp = new RegExp("^(http\:\/\/|https\:\/\/)?([a-z0-9][a-z0-9\-]*\\.)+(.)*");

    $.validator.addMethod("regex", function (value, element, params) {
            if (value)
                return regexp.test(value);

            return true
        },
        "Veuillez saisir une URL valide."
    );

    jQuery.validator.addMethod("greaterThanNow", function (value, element, params) {

        if (value) {
            val = value.split('/');

            var inputDate = new Date(val[2], val[1] - 1, val[0]);
            var paramDate = new Date();

            return inputDate.setHours(0, 0, 0, 0) >= paramDate.setHours(0, 0, 0, 0);
        }
        return true;

    }, 'La date doit être dans le futur.');

    jQuery.validator.addMethod("dateRequiredWhen", function (value, element, params) {
        if ($('#alert_form_date_req').prop('checked')) {
            return true;
        }
        if (value) {
            return true;
        } else {
            return false;
        }


    }, 'La date est obligatoire.');

    jQuery.validator.addMethod("productRequiredWhen", function (value, element, params) {
        if ($(params).prop('checked')) {

            if (value) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }, 'Le produit est obligatoire.');


    var recommendedBonus = 0;

    jQuery.validator.addMethod("comissionMin", function (value, element, params) {
        if ($('#alert_form_option_0').prop('checked')) {
            recommendedBonus = 5;
            if (value < 5) {
                return false;
            }
        } else {
            recommendedBonus = 12;
            if (value < 12) {
                return false
            }
        }
        return true;
    }, function (params, element) {
        return 'Le bonus doit etre supérieure à ' + recommendedBonus + '.';
    });


    var recommendedBuyBonus = 12;

    jQuery.validator.addMethod("buyBonus", function (value, element, params) {

        if ($('#alert_form_option_0').prop('checked')) {
            return true;
        }

        if (parseFloat(value) >= recommendedBuyBonus) {
            return true;
        } else {
            return false;
        }

    }, function (params, element) {
        return 'Le bonus doit etre supérieure à 12 €.';
    });

    $('#alert_form').validate({
            rules: {
                'alert_form[departureLocation]': {
                    required: true
                },
                'alert_form[arrivalLocation]': {
                    required: true
                },
                'alert_form[departureDate]': {
                    dateRequiredWhen: true,
                    greaterThanNow: true
                },
                'alert_form[product]': {
                    productRequiredWhen: '#alert_form_option_0'
                },
                'alert_form[dimension]': {
                    required: true
                },
                'alert_form[description]': {
                    required: true
                },
                'alert_form[productName]': {
                    productRequiredWhen: '#alert_form_option_1'
                },
                'alert_form[productWeight]': {
                    required: true
                },
                'alert_form[comission]': {
                    comissionMin: true,
                    buyBonus: true
                },
                'alert_form[price]': {
                    productRequiredWhen: '#alert_form_option_1',
                    min: 1
                },
                'alert_form[link]': {
                    regex: true
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
                'alert_form[departureLocation]': "La ville de départ est obligatoire.",
                'alert_form[arrivalLocation]': "La ville d'arrivée est obligatoire.",
                'alert_form[dimension]': "Le produit doit avoir une dimension.",
                'alert_form[description]': "La description est obligatoire.",
                'alert_form[productWeight]': "Le produit doit avoir un poids."
            }
        }
    );

    $("input[name='alert_form[dimension]'], #alert_form_productWeight").on('change', function () {
        if ($('#alert_form_option_0').prop('checked')) {
            getBonus();
        }
    });

    $('#alert_form_comission').on('change',function () {
        if ($('#alert_form_option_0').prop('checked')) {
            total = (parseFloat(($(this).val() == '') ? 0 : $(this).val()) * 28 / 25).toFixed(2);
            $('#alert_form_total').val(total);
            $(this).val(Math.round(parseFloat($(this).val())));
            $('#alert_form').validate().element('#alert_form_comission');
        } else {
            total = (parseFloat(($("#alert_form_comission").val() == '') ? 0 : $("#alert_form_comission").val()) +
                parseFloat(($("#alert_form_price").val() == '') ? 0 : $("#alert_form_price").val()) * 28 / 25).toFixed(2);
            $('#alert_form_total').val(total);
            $(this).val(parseFloat($(this).val()).toFixed(2));
            $('#alert_form').validate().element('#alert_form_comission');
            $('#alert_form').validate().element('#alert_form_price');
        }
    });

    $('#alert_form_price').on('change',function () {
        if ($('#alert_form_option_1').prop('checked')) {

            var recommended = 12;
            var price = parseFloat(($("#alert_form_price").val() == '') ? 0 : $("#alert_form_price").val());
            if (price > 80) {
                recommended = (price / 100) * 15;
            }
            $("#alert_form_comission").val(Math.round(recommended))
            total = (recommended + price * 28 / 25).toFixed(2);
            $('#alert_form_total').val(total);
            $('#alert_form').validate().element('#alert_form_comission');
            $('#alert_form').validate().element('#alert_form_price');
        }
    });






    function getBonus() {
        var weight = $('#alert_form_productWeight').val();
        var dimension = $("input[name='alert_form[dimension]']:checked").val();

        $.ajax({
            url: Routing.generate('get_bonus'),
            type: 'POST',
            data: {weight: weight, dimension: dimension},
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    $('#alert_form_total').val(data.total.toFixed(2));
                    $('#alert_form_comission').val(Math.round(data.bonus));
                }
            }
        });
    }

    $('#alert_form_comission, #alert_form_price').on('keydown', function (e) {

        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 188]) !== -1 ||
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            if (e.keyCode == 190 || e.keyCode == 188) {
                if ($(this).val().indexOf(".") > -1 || $(this).val().indexOf(",") > -1) {
                    e.preventDefault();
                    return;
                }
                if (e.keyCode == 188) {
                    $(this).val($(this).val() + '.');
                    e.preventDefault();
                    return;
                }
            }
            return;
        }
        if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

});