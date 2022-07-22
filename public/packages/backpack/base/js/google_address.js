let map, infoWindow, vmarker,pos,previouslatValue,previouslongValue,fmethod;



function initialize() {
    googleAddress()
     previouslatValue = $("#address-latitude").val();
     previouslongValue = $("#address-longitude").val();
     fmethod = $("input[name=_method]").val();


    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    const myLatLng = { lat: -25.363, lng: 131.044 };
    const map = new google.maps.Map(document.getElementById('address-map'), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 13,

    });
    const vmarker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Your position',
        draggable: true
    });
    infoWindow = new google.maps.InfoWindow()

    const savedlat = document.getElementById("address-latitude").value;
    const savedlong = document.getElementById("address-longitude").value;


    if(parseFloat(savedlat)>0 && parseFloat(savedlong)>0)
    {
        var latlng1 = new google.maps.LatLng(savedlat, savedlong);
        vmarker.setPosition(latlng1);
        vmarker.setVisible(true);

        map.setCenter(latlng1);

        map.setZoom(15);

    }
    else {

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    var latlng = new google.maps.LatLng(pos.lat, pos.lng);


                    vmarker.setPosition(pos);
                    vmarker.setVisible(true);
                    infoWindow.setPosition(pos);
                    //infoWindow.setContent("Location found.");
                    //infoWindow.open(map);
                    map.setCenter(pos);
                },
                () => {
                    handleLocationError(true, infoWindow, map.getCenter());
                }
            );
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
    }



    // const locationInputs = document.getElementsByClassName("map-input");

    const autocompletes = [];
    const geocoder = new google.maps.Geocoder;
    for (let i = 0; i < locationInputs.length; i++) {

        const input = locationInputs[i];
        const fieldKey = input.id.replace("-input", "");
        const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

        const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
        const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

        var latlng = new google.maps.LatLng(latitude, longitude);
        vmarker.setPosition(latlng);
        vmarker.setVisible(isEdit);

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({input: input, map: map, marker: vmarker, autocomplete: autocomplete});

    }

    for (let i = 0; i < autocompletes.length; i++) {
        const input = autocompletes[i].input;
        const autocomplete = autocompletes[i].autocomplete;
        const map = autocompletes[i].map;
        const marker = autocompletes[i].marker;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            marker.setVisible(false);
            const place = autocomplete.getPlace();

            geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    const lat = results[0].geometry.location.lat();
                    const lng = results[0].geometry.location.lng();
                    setLocationCoordinates(autocomplete.key, lat, lng);
                }
            });

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                input.value = "";
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

        });

    }



    google.maps.event.addListener(
        vmarker,
        'dragend',
        function(a) {
            setLocationCoordinates(null, a.latLng.lat().toFixed(8), a.latLng.lng().toFixed(8));
            var latlng = new google.maps.LatLng( a.latLng.lat().toFixed(8), a.latLng.lng().toFixed(8));
            map.setCenter(latlng);
            //console.log(latlng);
            map.setZoom(15);


        }
    );

}

function setLocationCoordinates(key, lat, lng) {
    const latitudeField = document.getElementById("address-latitude");
    const longitudeField = document.getElementById("address-longitude");
    latitudeField.value = lat;
    longitudeField.value = lng;

        if(lat !=previouslatValue)
        {


            $('#map_changed').attr('required', 'true');
            $("#map_changedlbl").css("color","red");
            $("#map_changed").css("outline","4px solid red");
            $('#map_changed').prop('checked', false);

        }
        if(lng !=previouslongValue)
        {
            //console.log(fmethod);

            $('#map_changed').attr('required', 'true');
            $('#map_changed').prop('checked', false);
            $("#map_changedlbl").css("color","red");
            $("#map_changed").css("outline","2px solid red");

        }



}

function googleAddress() {
    const myLatLng = { lat: -25.363, lng: 131.044 };
    const map = new google.maps.Map(document.getElementById('address-map'), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 13,

    });
    const vmarker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Your position',
        draggable: true
    });

    const locationInputs = document.getElementsByClassName("map-input");
    const autocompletes = [];
    const geocoder = new google.maps.Geocoder;
    for (let i = 0; i < locationInputs.length; i++) {

        const input = locationInputs[i];
        const fieldKey = input.id.replace("-input", "");
        const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

        const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
        const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

        var latlng = new google.maps.LatLng(latitude, longitude);
        vmarker.setPosition(latlng);
        vmarker.setVisible(isEdit);

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({input: input, map: map, marker: vmarker, autocomplete: autocomplete});
    }

}
