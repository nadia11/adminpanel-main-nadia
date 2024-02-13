
$(document).ready(function(){
    "use strict";

    var maps_icon = gmap_info.maps_icon;
    var site_name = gmap_info.site_name;
    var gmap_contact = gmap_info.gmap_contact;
    var gmap_latitude = gmap_info.gmap_latitude;
    var gmap_longitude = gmap_info.gmap_longitude;
    // var driver_markers = '';
    var driver_markers = gmap_info.driver_markers;

    function LoadDriverMarkers() {
        $.get(gmap_info.ajax_url +"/map/load-driver-markers", function( response ) {
            driver_markers = response;
        });
    }

    var map;
    var bangladesh = new google.maps.LatLng( 23.6850, 90.3563 );
    var mapDiv = document.getElementById('googleMap');
    // var MapTypeId = google.maps.MapTypeId.ROADMAP;  //HYBRID /ROADMAP /SATELLITE /TERRAIN
    let markers = [];

    //google.maps.event.addListener(map,'click', function() { alert(); });
    const geocoder = new google.maps.Geocoder();

    function liveTrackingMapInit() {
        var styledMapType = new google.maps.StyledMapType([
            {stylers: [{ hue: "#9e0000" }]},
            {featureType: "road", elementType: "geometry", stylers: [ { lightness: 100 }, { visibility: "simplified" }]},
            {featureType: "road", elementType: "labels", stylers: [{ visibility: "off" }]}
        ],
        {name: 'Styled Map'});

        var nightMoodMapType = new google.maps.StyledMapType([
            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {featureType: 'administrative.locality', elementType: 'labels.text.fill', stylers: [{color: '#d59563'}]},
            {featureType: 'poi', elementType: 'labels.text.fill', stylers: [{color: '#d59563'}]},
            {featureType: 'poi.park', elementType: 'geometry', stylers: [{color: '#263c3f'}]},
            {featureType: 'road', elementType: 'geometry', stylers: [{color: '#38414e'}]},
            {featureType: 'road', elementType: 'geometry.stroke', stylers: [{color: '#212a37'}]},
            {featureType: 'road', elementType: 'labels.text.fill', stylers: [{color: '#9ca5b3'}]},
            {featureType: 'road.highway', elementType: 'geometry', stylers: [{color: '#746855'}]},
            {featureType: 'road.highway', elementType: 'geometry.stroke', stylers: [{color: '#1f2835'}]},
            {featureType: 'road.highway', elementType: 'labels.text.fill', stylers: [{color: '#f3d19c'}]},
            {featureType: 'transit', elementType: 'geometry', stylers: [{color: '#2f3948'}]},
            {featureType: 'transit.station', elementType: 'labels.text.fill', stylers: [{color: '#d59563'}]},
            {featureType: 'water', elementType: 'geometry', stylers: [{color: '#17263c'}]},
            {featureType: 'water', elementType: 'labels.text.fill', stylers: [{color: '#515c6d'}]},
            {featureType: 'water', elementType: 'labels.text.stroke', stylers: [{color: '#17263c'}]}
        ],
        {name: 'Night Mood'});

        var mapOptions = {
            zoom: 10,
            maxZoom: 20,
            minZoom: 4,
            center: new google.maps.LatLng(gmap_latitude, gmap_longitude),
            MapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,
            mapTypeId: "satellite",
            mapTypeControl: true, //map or satelite
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                // style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                position: google.maps.ControlPosition.TOP_LEFT,
                mapTypeIds: ['roadmap', 'satellite', 'night_mood', 'styled_map'] //'roadmap', 'satellite', 'hybrid', 'terrain', 'night_mood', 'styled_map'
            },

            zoomControl: true,
            zoomControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM, style: google.maps.ZoomControlStyle.SMALL, },

            scaleControl: true,
            streetViewControl: true,
            streetViewControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },

            fullscreenControl: true,
            fullscreenControlOptions: { position: google.maps.ControlPosition.RIGHT_TOP },

            visibility:new google.maps.MVCObject, /** for show/hide marker**/
        }
        const map = new google.maps.Map(mapDiv, mapOptions);

        /************** Associate the styled map with the MapTypeId and set it to display. */
        map.mapTypes.set('night_mood', nightMoodMapType);
        map.setMapTypeId('night_mood');
        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');
        map.setTilt(45);

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(gmap_latitude, gmap_longitude),
            icon: maps_icon,
            draggable: true,
            map: map,
            animation: google.maps.Animation.DROP,
        });
        marker.setMap(map);

        addYourLocationButton(map, marker);
        addHomeButton(map);


        /**** drivers vehicles ***/
        var InfoWindow = new google.maps.InfoWindow();

        for (let i=0; i<driver_markers.length; i++) {
            addMarkerWithTimeout(driver_markers[i], i * 500);
        }

        function addMarkerWithTimeout(position, timeout) {
            window.setTimeout(() => {
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(Number(position.latitude), Number(position.longitude)),
                    map: map,
                    icon: gmap_info.image_url +"/marker_"+position.vehicle_marker+"_"+position.driver_status+".png",
                    //animation: google.maps.Animation.DROP,
                    title: position.driver_status
                });
                markers.push(marker);

                google.maps.event.addListener(marker, 'click', function(){
                    InfoWindow.setPosition({lat: Number(position.latitude), lng: Number(position.longitude)});
                    $.get(gmap_info.ajax_url +"/map/get-map-infowindow-content/"+ position.driver_id, function( response ) {
                        var driver_info = '';
                        driver_info += '<strong style="color: #007cba">Driver: </strong>'+ response['drivers_info'].driver_name +' (<a href="tel:'+ response['drivers_info'].driver_mobile +'">'+ response['drivers_info'].driver_mobile +'</a>)<br />';
                        driver_info += '<strong style="color: #007cba">Current Location: </strong>'+response.driver_location+'<br />';

                        if (response['drivers_info'].driver_status === 'on_trip') {
                            driver_info += '<strong style="color: #007cba">Rider: </strong>'+ response['drivers_info'].rider_name +' ('+ response['drivers_info'].rider_mobile +')<br />';
                            driver_info += '<strong style="color: #007cba">From: </strong>'+ response['drivers_info'].trip_from +'<br /> <strong style="color: #007cba">To: </strong>'+response['drivers_info'].trip_to +'<br />';
                            driver_info += '<strong style="color: #007cba">Vehicle: </strong>'+ response['drivers_info'].vehicle_type.toLocaleUpperCase() +', <strong style="color: #007cba"> Distance: </strong>'+ response['drivers_info'].distance +', <strong style="color: #007cba"> Fare: </strong>'+response['drivers_info'].fare +'<br />';
                        }
                        InfoWindow.setContent('<div style="font-size: 14px; text-align: center; line-height: 24px">'+driver_info+'</div>');
                        InfoWindow.open(map, marker);
                        marker.setPosition({lat: Number(position.latitude), lng: Number(position.longitude)});
                        map.panTo({lat: Number(position.latitude), lng: Number(position.longitude)});
                        map.setZoom(16);
                        setTimeout(function(){InfoWindow.close();}, 10000);
                    });
                });

                /******* Specific Marker Hide *******/
                if(typeof map.get('visibility').get(position.driver_status)==='undefined'){
                    map.get('visibility').set(position.driver_status, true);
                }
                marker.bindTo('visible',map.get('visibility'), position.driver_status);

            }, timeout);
        }


        setInterval(function () {
            delete_driver_markers();
            LoadDriverMarkers();
            add_driver_markers();
        }, 15000);

        function delete_driver_markers() {
            for (let i = 0; i < driver_markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }

        function add_driver_markers() {
            for (let i = 0; i < driver_markers.length; i++) {
                addMarkerWithTimeout(driver_markers[i], i * 10);
            }
        }

        $('#refresh_marker').on('click', function (event) {
            delete_driver_markers();
            LoadDriverMarkers();
            add_driver_markers();
        });


        document.getElementById("division_filter").addEventListener("change", () => {
            var selectedMode = document.getElementById('division_filter').value;
            if(Number(selectedMode) === 0 ) {
                map.setCenter({lat: Number(gmap_latitude), lng: Number(gmap_longitude)});
                map.panTo({lat: Number(gmap_latitude), lng: Number(gmap_longitude)});
                marker.setPosition({lat: Number(gmap_latitude), lng: Number(gmap_longitude)});
                map.setZoom(10);
            }
            else {
                geocoder.geocode({ address: selectedMode }, (results, status) => {
                    if (status === "OK") {
                        map.setCenter(results[0].geometry.location);
                        map.setZoom(10);
                        //new google.maps.Marker({ map: map, position: results[0].geometry.location });
                        marker.setPosition({ lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng() });
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            }
        });

        document.getElementById("district_filter").addEventListener("change", () => {
            var selectedMode = document.getElementById('district_filter').value;

            if(Number(selectedMode) === 0 ) {
                map.setCenter({lat: Number(gmap_latitude), lng: Number(gmap_longitude)});
                map.panTo({lat: Number(gmap_latitude), lng: Number(gmap_longitude)});
                marker.setPosition({lat: Number(gmap_latitude), lng: Number(gmap_longitude)});
                map.setZoom(10);
            }
            else {
                geocoder.geocode({ address: selectedMode }, (results, status) => {
                    if (status === "OK") {
                        map.setCenter(results[0].geometry.location);
                        map.setZoom(14);
                        //new google.maps.Marker({ map: map, position: results[0].geometry.location });
                        marker.setPosition({ lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng() });
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            }
        });


        $('.viewDriverInMap').on('click', function (event) {
            var latitude = $(this).data("latitude");
            var longitude = $(this).data("longitude");
            var loop_count = $(this).data("loop_count");
            map.panTo(new google.maps.LatLng(Number(latitude), Number(longitude)));
            map.setZoom(16);
            InfoWindow.open(map);

            google.maps.event.trigger(markers[Number(loop_count)-1], 'click');
        });

        $('#filter_online_drivers').on('click', function (event) {
            var filter = 'online';

            if($(this).hasClass('btn-danger')){
                $(this).removeClass('btn-danger').addClass('btn-outline-danger');
                $("#drivers_table").find('tr.'+filter).fadeOut('slow');
            } else {
                $(this).removeClass('btn-outline-danger').addClass('btn-danger');
                $("#drivers_table").find('tr.'+filter).fadeIn('slow');
            }
            map.get('visibility').set(filter, !map.get('visibility').get(filter));
        });


        $('#filter_ontrip_drivers').on('click', function (event) {
            var filter = 'on_trip';

            if($(this).hasClass('btn-success')){
                $(this).removeClass('btn-success').addClass('btn-outline-success');
                $("#drivers_table").find('tr.'+filter).fadeOut('slow');
            } else {
                $(this).removeClass('btn-outline-success').addClass('btn-success');
                $("#drivers_table").find('tr.'+filter).fadeIn('slow');
            }
            map.get('visibility').set(filter, !map.get('visibility').get(filter));
        });

    } //initMap
    google.maps.event.addDomListener(window, 'load', liveTrackingMapInit);


    function addYourLocationButton (map, marker) {
        var controlDiv = document.createElement('div');

        var firstChild = document.createElement('button');
        firstChild.style.backgroundColor = '#fff';
        firstChild.style.border = 'none';
        firstChild.style.outline = 'none';
        firstChild.style.width = '40px';
        firstChild.style.height = '40px';
        firstChild.style.borderRadius = '2px';
        firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
        firstChild.style.cursor = 'pointer';
        firstChild.style.marginRight = '10px';
        firstChild.style.padding = '0';
        firstChild.title = 'Your Location';
        controlDiv.appendChild(firstChild);

        var secondChild = document.createElement('div');
        secondChild.style.margin = '8px';
        secondChild.style.width = '25px';
        secondChild.style.height = '25px';
        secondChild.style.backgroundImage = 'url(../images/mylocation-sprite-2x.png)';
        secondChild.style.backgroundSize = '250px 25px';
        secondChild.style.backgroundPosition = '0 0';
        secondChild.style.backgroundRepeat = 'no-repeat';
        firstChild.appendChild(secondChild);

        google.maps.event.addListener(map, 'center_changed', function () {
            secondChild.style['background-position'] = '0 0';
        });

        var imgX = '0';
        var animationInterval = setInterval(function () {
            imgX = imgX === '-25' ? '0' : '-25';
            secondChild.style['background-position'] = imgX+'px 0';
        }, 500);

        firstChild.addEventListener('click', function () {
            //if ('geolocation' in navigator) {
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(show_location, show_error, {
                    timeout: 1000,
                    enableHighAccuracy: true
                });
            } else {
                clearInterval(animationInterval);
                secondChild.style['background-position'] = '0 0';
                alert('Geolocation is not supported by your browser.');
            }
        });

        function show_location (position) {
            //var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var latlng = { lat: position.coords.latitude, lng: position.coords.longitude };
            clearInterval(animationInterval);
            secondChild.style['background-position'] = '-144px 0';

            //$("#show_location").html("Latitude: " + position.coords.latitude + " </br>Longitude:" + position.coords.longitude);

            infoWindow = new google.maps.InfoWindow({ map: map });
            infoWindow.setPosition(latlng);
            infoWindow.setContent("Latitude : " + position.coords.latitude.toFixed(7) + " </br>Longitude :" + position.coords.longitude.toFixed(7));
            map.panTo(latlng);
            // map.setCenter(latlng);
            marker.setPosition(latlng);
            map.setZoom(14);
        }

        function show_error(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED: alert("User denied the request for Geolocation."); break;
                case error.POSITION_UNAVAILABLE: alert("Location data is unavailable."); break;
                case error.TIMEOUT: alert("Request timeout."); break;
                case error.UNKNOWN_ERROR: alert("An unknown error occurred."); break;
            }
        }

        controlDiv.index = 1;
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
    }


    /************** Create a DIV to hold the control and call HomeControl() */
    // var homeControlDiv = document.createElement('div');
    // var homeControl = new HomeControl(homeControlDiv, map);
    // // homeControlDiv.index = 1;
    // map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(homeControlDiv);

    // Add a Home control that returns the user to Bangladesh
    // function HomeControl(controlDiv, map) {
    //     controlDiv.style.padding = '5px';
    //     var controlUI = document.createElement('div');
    //     controlUI.style.backgroundColor = 'white';
    //     controlUI.style.border='2px solid rgba(192, 57, 43,1.0)';
    //     controlUI.style.borderRadius = '3px';
    //     controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    //     controlUI.style.cursor = 'pointer';
    //     controlUI.style.textAlign = 'center';
    //     controlUI.style.marginBottom = '22px';
    //     controlUI.title = HomeControlTitle;
    //     controlDiv.appendChild(controlUI);
    //
    //     var controlText = document.createElement('div');
    //     controlText.style.fontFamily='Roboto,Arial,sans-serif';
    //     controlText.style.color = 'rgba(192, 57, 43,1.0)';
    //     controlText.style.fontSize='12px';
    //     controlText.style.lineHeight = '38px';
    //     controlText.style.paddingLeft = '4px';
    //     controlText.style.paddingRight = '4px';
    //     controlText.innerHTML = HomeControlText;
    //     controlUI.appendChild(controlText);
    //
    //     // Setup click-event listener: simply set the map to Bangladesh
    //     google.maps.event.addDomListener(controlUI, 'click', function() { map.setCenter(bangladesh); });
    // }

    function addHomeButton(map) {
        var controlDiv = document.createElement('div');
        controlDiv.style.padding = '5px';

        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = 'white';
        controlUI.style.border='2px solid rgba(192, 57, 43,1.0)';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.textAlign = 'center';
        controlUI.style.marginBottom = '22px';
        controlUI.title = "Click to recenter the map";
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.style.fontFamily='Roboto,Arial,sans-serif';
        controlText.style.color = 'rgba(192, 57, 43,1.0)';
        controlText.style.fontSize='12px';
        controlText.style.lineHeight = '38px';
        controlText.style.paddingLeft = '4px';
        controlText.style.paddingRight = '4px';
        controlText.innerHTML = "Bangladesh";
        controlUI.appendChild(controlText);

        controlUI.addEventListener('click', function() {
            const trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(map);
            map.setZoom(7);
            map.setCenter(bangladesh);
        });

        controlDiv.index = 1;
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
    }
});
