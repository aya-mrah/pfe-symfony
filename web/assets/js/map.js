function initMap() {
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: {lat: 41.85, lng: -87.65}
            });
            directionsDisplay.setMap(map);


            autocomplete1 = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('start')),
                {types: ['geocode']});
            autocomplete2 = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('end')),
                {types: ['geocode']});
            autocomplete3 = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('waypoints')),
                {types: ['geocode']});
            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            document.getElementById('waypoints').addEventListener('blur', function() {
                calculateAndDisplayRoute(directionsService, directionsDisplay);
            });
            autocomplete1.addListener('place_changed', fillInAddress);
            autocomplete2.addListener('place_changed', fillInAddress);
            autocomplete3.addListener('place_changed', fillInAddress);

        }

        function calculateAndDisplayRoute(directionsService, directionsDisplay) {
            var waypts = [];
            var way = document.getElementById('waypoints');
            waypts.push({
                location: way.value,
                stopover: true
            });


            directionsService.route({
                origin: document.getElementById('start').value,
                destination: document.getElementById('end').value,
                waypoints: waypts,
                optimizeWaypoints: true,
                travelMode: 'DRIVING'
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                    var route = response.routes[0];
                    var summaryPanel = document.getElementById('directions-panel');
                    summaryPanel.innerHTML = '';
                    // For each route, display summary information.
                    for (var i = 0; i < route.legs.length; i++) {
                        var routeSegment = i + 1;
                        summaryPanel.innerHTML += '<b><i class="fa fa-map-signs" aria-hidden="true"></i>&nbsp;Route Segment: ' + routeSegment +
                            '</b><br> <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;';
                        summaryPanel.innerHTML += route.legs[i].start_address + '&nbsp;<i class="fa fa-long-arrow-right" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp;';
                        summaryPanel.innerHTML += route.legs[i].end_address + '<br> Distance : &nbsp;&nbsp;&nbsp;';
                        summaryPanel.innerHTML += route.legs[i].distance.text + '<br>';
                    }
                } else
                    {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }