async function initMap($el) {
    
    // Request needed libraries.
    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary(
      "marker",
    );
 
    const map = new google.maps.Map($el[0], {
      zoom: $el.data('zoom') || 12,
      center: { lat: 35.6870, lng: -105.9378 },
      mapId: "DEMO_MAP_ID",
    });
    
    const infoWindow = new google.maps.InfoWindow({
        content: "",
        disableAutoPan: true,
    });
    
    var latlngbounds = new google.maps.LatLngBounds();

    const markers = locations.map((position, i) => {
        const label = (i + 1).toString();
 
        const pinGlyph = new google.maps.marker.PinElement({
            glyph: label,
            glyphColor: "white",
        });
        const marker = new google.maps.marker.AdvancedMarkerElement({
            position,
            content: pinGlyph.element,
        });

        latlngbounds.extend(marker.position);
        // markers can only be keyboard focusable when they have click listeners
        // open info window when marker is clicked
        marker.addListener("click", () => {
          infoWindow.setContent(position.lat + ", " + position.lng);
          infoWindow.open(map, marker);
        });
        return marker;
      });
      
    var bounds = new google.maps.LatLngBounds();
    map.setCenter(latlngbounds.getCenter());
    map.fitBounds(latlngbounds);

    // Add a marker clusterer to manage the markers.
    new markerClusterer.MarkerClusterer({ markers, map });
}

  

  
(function($) {
  // Render maps on page load.
    $(document).ready(function(){
        
        $('.acf-map').each(function(){
            initMap( $(this) );   
            
        });
    });
  
})(jQuery);