function initializeAutocomplete(id) {
    var element = document.getElementById(id);


    if (element) {

        var autocomplete = new google.maps.places.Autocomplete(element, {types: ['geocode']});

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();

            console.log(place);  // Uncomment this line to view the full object returned by Google API.

            for (var i in place.address_components) {
                var component = place.address_components[i];
                for (var j in component.types) {  // Some types are ["country", "political"]
                    var type_element = document.getElementById(component.types[j]);
                    if (type_element) {
                        type_element.value = component.long_name;
                    }
                }
            }

        });

        // $('#' + id).on('change', function () {
        //     var firstResult;
        //
        //     $(".pac-container .pac-item").each(function () {
        //         if ($(this).text().toLowerCase().startsWith($('#' + id).val().toLowerCase())) {
        //             firstResult = $(this).text();
        //             return false;
        //         }
        //     });
        //
        //     var geocoder = new google.maps.Geocoder();
        //     geocoder.geocode({"address": firstResult}, function (results, status) {
        //         if (status == google.maps.GeocoderStatus.OK) {
        //             placeName = results[0].address_components[0].long_name;
        //             $('#' + id).val(placeName);
        //         } else {
        //             $('#' + id).val('');
        //         }
        //     });
        // });
    }
}

google.maps.event.addDomListener(window, 'load', function () {
    initializeAutocomplete('trip_from');
    initializeAutocomplete('trip_to');
    initializeAutocomplete('index_from');
    initializeAutocomplete('index_to');
    initializeAutocomplete('search_from');
    initializeAutocomplete('search_to');
    initializeAutocomplete('search_from_trav');
    initializeAutocomplete('search_to_trav');
    initializeAutocomplete('alert_form_departureLocation');
    initializeAutocomplete('alert_form_arrivalLocation');

});