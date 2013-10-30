var eworld = new google.maps.LatLng(33.801842, -117.960404);
var marker;
var map;
var contentString = '<div id="content" height="50%">'+
'<h4>E-World Computers</h4>'+
'<img class="right" width="40%" src="http://localhost/eWorldComputers/assets/images/IMG_5139.jpg" />'+
'<address>Address:<br /><a target="_blank" href="https://maps.google.com/?q=e+world+computers">9896 Katella Ave.<br />Anaheim, CA 92804‎</a></address>'+
'<p>Business Phone:  (714) 539-9199</p>'+
'<p>Store Website:  <a href="http://localhost/eWorldComputers">http://localhost/eWorldComputers</a></p>'+
'<p>Computer Repair Service, Computer Store</p>'+
'<p>We have been serving the community with services and repairs for your computers since 2006. We offer a great variety for all your needs. Call us today!</p>'+
'</div>';

var infowindow = new google.maps.InfoWindow({
    content: contentString
});


function initialize() {
    var mapOptions = {
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: eworld
    };

    map = new google.maps.Map(document.getElementById('map_canvas'),
        mapOptions);

    marker = new google.maps.Marker({
        map:map,
        animation: google.maps.Animation.BOUNCE,
        position: eworld

    });
    google.maps.event.addListener(marker, 'click', toggleBounce);
}

function toggleBounce() {

    if (marker.getAnimation() != null) {
        marker.setAnimation(null);
        infowindow.open(map,marker);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
        infowindow.close();
    }
}

google.maps.event.addDomListener(window, 'load', initialize);