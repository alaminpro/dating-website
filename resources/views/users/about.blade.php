<p class="page-title text-capitalize mb-1 mt-3 pl-4">About Me</p>
<div id="user-about" class="text-muted pl-4 abt-spc">{!! $user->about !!}</div>
<p class="page-title text-capitalize mb-1 pl-4 ">Location</p>
@if($user->address !=null && $user->country)
<p class="user-address mb-1 pl-4 mt-2"><i class="fas fa-map-marker-alt"></i> {!!
    fulladdress($user->address, $user->country) !!}
</p>@endif
<div id="usermap" class="ml-4 mr-3"></div>
<p class="page-title text-capitalize mb-1 mt-3 pl-4">Interests</p>
<div id="user-preference" class="pl-4 padd-bottom-20">
    @foreach($user->interests as $interest)
    <a href="javascript:void(0)" class="user-interest">{!! $interest->text !!}</a>
    @endforeach
</div>
</div>
<script>
    function showUserLocation() {
        var userlocation = {
            lat: {!!$user->lat!!},
            lng: {!!$user->lng!!}
        };
        var map = new google.maps.Map(
            document.getElementById('usermap'), {
                zoom: 15,
                center: userlocation,
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: false
            });
        // The marker, positioned at Uluru
        var icon = {
            url: '{!! avatar($user->avatar, $user->gender) !!}',
            size: new google.maps.Size(50, 50),
            origin: new google.maps.Point(0, 0),
            scaledSize: new google.maps.Size(50, 50),
            shape: {
                coords: [25, 25, 25],
                type: 'circle'
            },
            optimized: false
        };
        var myoverlay = new google.maps.OverlayView();
        myoverlay.draw = function() {
            this.getPanes().markerLayer.id = 'markerLayer';
        };
        myoverlay.setMap(map);
        var marker = new google.maps.Marker({
            position: userlocation,
            map: map,
            title: '{!! fullname($user->firstname, $user->lastname, strtolower($user->username)) !!}',
            icon: icon
        });
    }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_PLACE_API','AIzaSyBjVRkL8MOLaVd-fjloQguTIQDLAAzA4w0') !!}&callback=showUserLocation"
        async defer></script>