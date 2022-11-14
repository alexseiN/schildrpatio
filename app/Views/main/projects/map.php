<?php echo view('main/includes/head'); ?> 
<?php echo view('main/includes/top'); ?>

        <div class="main_top">
            
        
        <div id="map" style="height: 600px; position: relative; overflow: hidden;"></div>
     
            
        </div>

        
            

        



<script>
        var app_lang = 'en';

        var branches = [];
        
                    
                  
                    <?php if($items) { ?>
                    <?php $i=1; foreach($items as $item) { ?>
                    
                    
                    branches.push([<?=$i?>, '<?=$item->title?>', <?=$item->gps?>, 'object_2', 'map.svg', <?=$item->id?>]);
                  
                    
                    <?php $i++;} ?>
                    <?php } ?>
        
        var web_url = '';

        var domain = '/en';
    </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD85IqNDTQt5gqc-EHf2ZBnpsYtfd1R1wE"></script>


<script>
    
    var mapInit = 0;

function initialize() {
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var e = new google.maps.LatLng(<?=$curbranch->gps?>),
        a = {
            zoom: 3,
            center: e,
            scrollwheel: !1,
            draggable: !0,
            minZoom: 3,
            maxZoom: 17,
            streetViewControl: !1,
            mapTypeControl: !1,
            mapTypeId: google.maps.MapTypeId.TERRAIN,

            styles: [ { "featureType": "water", "elementType": "all", "stylers": [ { "hue": "#71d6ff" }, { "saturation": 100 }, { "lightness": -5 }, { "visibility": "on" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "hue": "#ffffff" }, { "saturation": -100 }, { "lightness": 100 }, { "visibility": "off" } ] }, { "featureType": "transit", "elementType": "all", "stylers": [ { "hue": "#ffffff" }, { "saturation": 0 }, { "lightness": 100 }, { "visibility": "off" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "hue": "#deecec" }, { "saturation": -73 }, { "lightness": 72 }, { "visibility": "on" } ] }, { "featureType": "road.highway", "elementType": "labels", "stylers": [ { "hue": "#bababa" }, { "saturation": -100 }, { "lightness": 25 }, { "visibility": "on" } ] }, { "featureType": "landscape", "elementType": "geometry", "stylers": [ { "hue": "#e3e3e3" }, { "saturation": -100 }, { "lightness": 0 }, { "visibility": "on" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "hue": "#ffffff" }, { "saturation": -100 }, { "lightness": 100 }, { "visibility": "simplified" } ] }, { "featureType": "administrative", "elementType": "labels", "stylers": [ { "hue": "#59cfff" }, { "saturation": 100 }, { "lightness": 34 }, { "visibility": "on" } ] } ]
        };
    for (map = new google.maps.Map(document.getElementById("map"), a), i = 0; i < markers1.length; i++) {
        addMarker(markers1[i], directionsService, directionsDisplay);
        directionsDisplay.setMap(map);
    }
}

function addMarker(e, directionsService, directionsDisplay) {
    var a = e[4],
        t = e[1],
        o = new google.maps.LatLng(e[2], e[3]),
        i = e[1],
        l = e[5];
    m = e[6];
    marker1 = new google.maps.Marker({
        title: t,
        position: o,
        category: a,
        metro_id: m,
        map: map,
        icon: {
            url: "../assets/main/img/" + l
        }
    });
    gmarkers1.push(marker1);
    google.maps.event.addListener(marker1, "click", function(e, a) {
        return function() {
            console.dir(e);
            console.dir(a);
            infoWindow.setContent(a);
            infoWindow.open(map.getCenter(), e);
            map.panTo(this.getPosition());
            map.setZoom(8);
            if(geolocation) {
                calculateAndDisplayRoute(directionsService, directionsDisplay, o);
            }
            return false;
        }
    }(marker1, i))
}

var gmarkers1 = [],
    markers1 = [],
    infoWindow = new google.maps.InfoWindow({
        content: ""
    });


markers1 = branches,

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}

initialize();

mapInit = 1;
// google.maps.event.trigger(map, 'resize');
/**/

function goMap(markerId, lat, lon){
    // google.maps.event.trigger(gmarkers1[markerId], 'click');
    $('html, body').animate({
        scrollTop: $("#branches_map").offset().top
    }, 1000);
    var center = new google.maps.LatLng(lat, lon);
    map.setZoom(3)
    map.panTo(center);
}
    
</script>


<?php echo view('main/includes/footer'); ?>
<?php echo view('main/includes/end'); ?>
       