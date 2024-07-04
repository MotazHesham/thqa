<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>خريطة ثقة</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('map/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('map/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('map/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('map/js/index.js') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <style>
        .active-type{
            background-color: #41af59 !important;
            color: white !important
        }
    </style>
</head>

<body dir="rtl">
    <nav class="navbar p-0 bg-white">
        <div class="container-fluid d-flex align-items-md-center align-items-sm-center justify-content-sm-between justify-content-md-between">
            <div class="content d-lg-inline-flex align-items-center g-lg-4">
                <button type="button" class="list-button">
                    <span alt="قائمة الخدمات" class="list-icon">
                        <img alt="ServiceList-blue" fetchpriority="high" width="35" height="35"
                            src="{{ asset('map/assets/ServiceList-blue.svg') }}" />
                    </span>
                </button>
                <a class="navbar-brand" href="#"><img src="{{ asset('assets/img/logo.png') }}"
                        width="140" height="50" alt="" /></a>
            </div>

            <div class="content-2 " id="navbarNav"> 
                <ul class="nav-list me-auto d-flex align-items-center justify-content-between"> 
                    <li class="nav-item"> 
                        <select class="form-control select2" id="owner-select" onchange="change_map_markers()">
                            <option value="">أختار المالك</option>
                            @foreach ($owners as $owner)
                                <option value="{{ $owner->id }}" >
                                    {{ $owner->user->fullName ?? '' }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="nav-item">
                        <a type="button" class="map-search item"><span class=" "><img width="15"
                                    height="15" decoding="async" data-nimg="1"
                                    src="{{ asset('map/assets/Listings-ListView.svg') }}"
                                    style="color: transparent; width: 15px; height: 15px" />
                            </span>
                            <input type="text" name="" id="pac-input" style="padding: 17px;border: 0;"
                                placeholder="البحث بالخريطة" id="">

                        </a>
                    </li>
                    <li class="nav-item">
                        <a type="button" href="{{ route('admin.buildings.create') }}" class="add-item item" data-text="اضافه">
                            <span><i class="fa-solid fa-plus"></i></span>
                            <span class="text">اضافه</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.home') }}" class=" profile-btn  d-flex justify-content-center align-items-center p-1 m-0"> 
                            <span class=" bg-gradient "><img alt="Profile" class="profile  border-0" width="15"
                                    height="15" src="{{ asset('map/assets/Profile.svg') }}" /></span> 
                        </a> 
                    </li>


                </ul>
            </div> 
        </div>
    </nav>
    <div class="main-container">
        <div class="map-container">
            <div class="main-secrean">
                <div id="map" class="map-screan "></div>
                <div class="sections position-fixed">
                    <div class="sections-content"> 
                        <div class="main-links d-flex flex-row align-items-center overflow-x-hidden p-2">
                            <a id="0" class="active-type building-type" onclick="change_building_type('all',this)">الكل</a>
                            @foreach (App\Models\Building::BUILDING_TYPE_SELECT as $key => $label)
                                <a id="0" class="building-type" onclick="change_building_type('{{$key}}',this)"><img src="{{ \App\Models\Building::BUILDING_TYPE_ICONS[$key] }}" alt="">{{ $label }}</a>
                            @endforeach
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyDjvU8Zqem3c-vJOpHCh4NmzB0xH8FBhQs&libraries=places&v=weekly">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="{{ asset('map/js/index.js') }}"></script>
    <script>
        $('#owner-select').select2();
    </script>
    <script>
        let infoObj = [];
        let map;
        let titles = [];
        let markers = [];
        let type = 'all';

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6,
                center: {
                    lat: 23.8859,
                    lng: 45.0792
                },
                mapTypeId: "roadmap",
            });

            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);

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

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });

            @foreach ($buildings as $building)
                titles.push({
                    'id': '{{ $building->id }}',
                    'owner_id': '{{ $building->owner_id }}',
                    'lat': parseInt('{{ $building->map_lat }}'),
                    'lng': parseInt('{{ $building->map_long }}'),
                    'type': '{{ $building->building_type }}',
                    'name': '{!! $building->get_details() !!}',
                    'building_images': '{!! $building->get_images() !!}',
                    'owner': '{{ $building->owner->user->fullName ?? '' }}',
                    'photo': '{{ $building->owner->user->photo ? $building->owner->user->photo->getUrl("preview") : asset("assets/img/avatar/user0.png") }}',
                    'icon' : '{{ \App\Models\Building::BUILDING_TYPE_ICONS[$building->building_type] }}'
                });
            @endforeach


            for (var i = 0; i < parseInt('{{ $buildings->count() }}'); i++) {
                var contentString = '<img style="padding:8px" width="120" height="120" src="' + titles[i].photo +
                    '"><h5>' + titles[i].owner + '</h5> ' + titles[i].name + titles[i].building_images ;
                const marker = new google.maps.Marker({
                    position: new google.maps.LatLng(titles[i].lat, titles[i].lng),
                    map: map,
                    title: titles[i].id,
                    type: titles[i].type,
                    icon: titles[i].icon,
                    owner_id : titles[i].owner_id
                });

                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 200,
                });

                marker.addListener("click", function() {
                    closeOtherInfo();
                    infowindow.open(map, marker);
                    infoObj[0] = infowindow;
                });
                markers.push(marker);
            }
        }

        function closeOtherInfo() {
            if (infoObj.length > 0) {
                infoObj[0].set('marker', null);
                infoObj[0].close();
                infoObj[0].length = 0;
            }
        } 
        window.onload = initMap;

        function change_building_type(building_type,elem){
            type = building_type;
            change_map_markers();
            var buildingTypeLinks = document.getElementsByClassName('building-type');
            for (var i = 0; i < buildingTypeLinks.length; i++) {
                buildingTypeLinks[i].classList.remove('active-type');
            }
            // Add 'active-type' class to the clicked <a> tag
            elem.classList.add('active-type');
        }
        
        function change_map_markers(){
            let owner_id = $('#owner-select').val();
            
            for (var i = 0; i < markers.length; i++) { 
                if(type == 'all'){
                    if(owner_id == ''){
                        markers[i].setMap(map);
                    }else{ 
                        markers[i].setMap(markers[i].owner_id == owner_id ? map : null); 
                    }
                }else{   
                    if (markers[i].type == type) { 
                        if(owner_id == ''){
                            markers[i].setMap(map);
                        }else{ 
                            markers[i].setMap(markers[i].owner_id == owner_id ? map : null); 
                        }
                    }else{ 
                        markers[i].setMap(null);
                    }
                } 
            }
        }
    </script>
</body>

</html>
