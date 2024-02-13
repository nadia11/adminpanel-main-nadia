$(document).ready(function(){
    var map;
    var mapDiv = document.getElementById('googleMap');
    var gmap_latitude = gmap_info.origin_lat;
    var gmap_longitude = gmap_info.origin_lon;
    var trip_from = gmap_info.trip_from;
    var trip_to = gmap_info.trip_to;

    function viewInMapInit() {
        var styledMapType = new google.maps.StyledMapType([
            {stylers: [{ hue: "#9e0000" }]},
            {featureType: "road", elementType: "geometry", stylers: [ { lightness: 100 }, { visibility: "simplified" }]},
            {featureType: "road", elementType: "labels", stylers: [{ visibility: "off" }]}
        ],
        {name: 'Styled Map'});

        var mapOptions = {
            zoom: 8,
            center: new google.maps.LatLng(gmap_latitude, gmap_longitude),
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: false,

            zoomControl: true,
            zoomControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
            scaleControl: true,
            streetViewControl: false,
            streetViewControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
            fullscreenControl: true,
            fullscreenControlOptions: { position: google.maps.ControlPosition.RIGHT_TOP },
        }
        var map = new google.maps.Map(mapDiv, mapOptions);
        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');


        //Begin Routing
        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);
        var request = {
            origin: trip_from,
            destination: trip_to,
            travelMode: 'DRIVING'
        };
        directionsService.route(request, function(result, status) {
            if (status === 'OK') {
                //directionsRenderer.setDirections(result); auto route & marker
                new google.maps.DirectionsRenderer({
                    map: map,
                    directions: result,
                    suppressMarkers: true,
                    suppressInfoWindows: true,
                    polylineOptions: { strokeColor: "red", strokeOpacity: 1.0, strokeWeight: 4 }
                });

                var leg = result.routes[0].legs[0];
                makeMarker(leg.start_location, icons.start, "title", map);
                makeMarker(leg.end_location, icons.end, 'title', map);
            }
        });

        function makeMarker(position, icon, title, map) {
            new google.maps.Marker({
                position: position,
                map: map,
                icon: icon,
                title: title
            });
        }

        var icons = {
        start: new google.maps.MarkerImage(
            gmap_info.start_icon,
            new google.maps.Size(100, 100),
            new google.maps.Point(0, 0),
            new google.maps.Point(26, 46)),

        end: new google.maps.MarkerImage(
            gmap_info.end_icon,
            new google.maps.Size(44, 32),
            new google.maps.Point(0, 0),
            new google.maps.Point(10, 10))
        };
    }
    google.maps.event.addDomListener(window, 'load', viewInMapInit);
});
