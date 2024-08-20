

    let markers = [];
    let circles = []; 
    let map ; 

    function locate(){
        navigator.geolocation.getCurrentPosition(myMap3,fail);
    }
    function fail(error){
        var txt;
        switch(error.code)
        {
            case error.PERMISSION_DENIED:
            txt = 'Location permission denied';
            break;
            case error.POSITION_UNAVAILABLE:
            txt = 'Location position unavailable';
            break;
            case error.TIMEOUT:
            txt = 'Location position lookup timed out';
            break;
            default:
            txt = 'Unknown position.'
        }
        myMap3({coords:{latitude:24.6,longitude:46.6}});
        // alert(txt);
    }
    
    function myMap3(position) {
        var mapCanvas = document.getElementById("map3");
        var mapOptions = {
            center:new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
            zoom: 14,
            mapTypeId: "roadmap",
        };
        map = new google.maps.Map(mapCanvas, mapOptions); 

        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            } 

            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();

            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                } 
                
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                
                addmarker(lat,lng);
                
                $('#map_lat').val(lat);
                $('#map_long').val(lng);

                
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
        
        addmarker(position.coords.latitude, position.coords.longitude); 

        // Configure the click listener.
        map.addListener("click", (mapsMouseEvent) => { 
            var lat = mapsMouseEvent.latLng.lat();
            var lng = mapsMouseEvent.latLng.lng();
            
            addmarker(lat,lng);

            $('#map_lat').val(lat);
            $('#map_long').val(lng);

            getPlaceInfo(lat, lng);
        });
    } 

    function getPlaceInfo(lat, lng) {
        const geocoder = new google.maps.Geocoder();
        const latlng = { lat: lat, lng: lng };

        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK") {  
                if (results[0]) {
                    const placeInfo = results[0].formatted_address;
                    $('#address').val(placeInfo);
                } else {
                    console.log('No results found');
                }
            } else {
                console.log('Geocoder failed due to: ' + status);
            }
        });
    }
    
    function addmarker(lat,lng,title = ''){
        for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
            circles[i].setMap(null);
        }

        const marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat,lng), 
            map,
            title: title,
        });
        markers.push(marker);
        
        var circle = new google.maps.Circle({
            center:new google.maps.LatLng(lat,lng), 
            radius: parseInt($('#area').val()), 
            fillColor: "#0000FF", 
            fillOpacity: 0.2, 
            map: map, 
            strokeColor: "#FFFFFF", 
            strokeOpacity: 0.6, 
            strokeWeight: 2
        });
        circles.push(circle);
    } 

    function changeLatLong(){
        const lat = parseFloat($('#map_lat').val());
        const lng = parseFloat($('#map_long').val());
        
        addmarker(lat,lng);
        getPlaceInfo(lat, lng);
    }