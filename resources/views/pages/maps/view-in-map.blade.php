@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fad fa-steering-wheel text-danger" aria-hidden="true"></i> Route</h2>

            <div class="box-tools float-right">
                <button type="button" class="btn btn-sm btn-outline-primary" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i> Reload</button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="mapouter">
                <div id="googleMap" style="margin: 0 auto 20px; overflow: hidden; background: none!important; width: 100%;" class="gmap_canvas"></div>
                <style>.mapouter{position:relative;text-align:right;height:480px;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:480px;width:1000px;}</style>
            </div>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>
@endsection

@section('custom_js')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('app.GOOGLE_MAPS_API_KEY') }}&callback=viewInMapInit"></script>

<script type="text/javascript">
    $(document).ready(function(){
        var map;
        var mapDiv = document.getElementById('googleMap');
        var gmap_latitude = "<?php echo $_GET['lat']; ?>";
        var gmap_longitude = "<?php echo $_GET['lng']; ?>";

        function viewInMapInit() {
            var styledMapType = new google.maps.StyledMapType([
                {stylers: [{ hue: "#9e0000" }]},
                {featureType: "road", elementType: "geometry", stylers: [ { lightness: 100 }, { visibility: "simplified" }]},
                {featureType: "road", elementType: "labels", stylers: [{ visibility: "off" }]}
            ],
            {name: 'Styled Map'});

            var mapOptions = {
                zoom: 12,
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

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(gmap_latitude, gmap_longitude),
                draggable: true,
                map: map,
                animation: google.maps.Animation.DROP,
            });
            marker.setMap(map);
        }
        google.maps.event.addDomListener(window, 'load', viewInMapInit);
    });
</script>
@endsection
