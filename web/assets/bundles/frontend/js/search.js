$(document).ready(function () {
    $('.login-before').on('click', function (e) {
        e.preventDefault();
        Modal.show('.login-modal');
    });

    $('#search-register').on('click', function (e) {
        e.preventDefault();
        Modal.show('.register-modal')
    });

    $('.transportationFilter input').on('change', function (e) {
        var transportations = [];
        $('.transportationFilter input').each(function () {
            if ($(this).is(':checked')) {
                transportations.push($(this).val());
            }
        });

        $('#transportationFilter').val(transportations.join());
        // $('.searchForm form').submit();
        search();
    });

    $('.periodFilter input').on('change', function (e) {
        var periods = [];
        $('.periodFilter input').each(function () {
            if ($(this).is(':checked')) {
                periods.push($(this).val());
            }
        });

        $('#periodFilter').val(periods.join());
        // $('.searchForm form').submit();
        search();
    });

    $('.photoFilter input').on('change', function (e) {
        if ($(this).is(':checked')) {
            $('#photoFilter').val('1');
        } else {
            $('#photoFilter').val('');
        }
        // $('.searchForm form').submit();
        search();
    });

    $('.buyFilter input').on('change', function (e) {
        if ($(this).is(':checked')) {
            $('#buyFilter').val('1');
        } else {
            $('#buyFilter').val('');
        }
        // $('.searchForm form').submit();
        search();
    });

    $('.rateFilter .star').on('click', function () {
        $parent = $(this).closest('.rateFilter');

        val = $(this).data('val') || 0;

        $('.rateFilter .star').removeClass('on');
        $parent.find('.star:lt(' + val + ')').addClass('on');
        $parent.data('val', val);
        $('#rateFilter').val(val);

        search();
        // $('.searchForm form').submit();
    });

    $('.lightStyleFilter').on('click', function (e) {
        e.preventDefault();
        $(this).closest('.collapsibleGroup').toggleClass('collapsed');

        if ($(this).closest('.collapsibleGroup').hasClass('collapsed')) {
            $('#sort').val('ASC');
        } else {
            $('#sort').val('DESC');
        }

        search();
    });

    function search () {
        var $form = $('#search_trip_form');
        var data = $form.serialize();

        console.log(data);

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: data,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.success) {
                    $('#search_share').attr('href',data.searchShare);
                    $('.mainSection').html(data.result);
                    mutualfriends();
                }
            }
        });
    }

    function mutualfriends() {
        $('.searchResult span.fbIcon > span').each(function() {
            var url = $(this).data('url');
            var count = 0;
            var span = $(this).text(count);

            if (url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        count = data.context.mutual_friends.summary.total_count;
                        if(count) {
                            span.text(count);
                        } else {
                            span.text(0);
                            $(this).parent().hide();
                        }
                    }
                });
            }
        });
    }

    mutualfriends();
});
