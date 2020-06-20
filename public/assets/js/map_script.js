var restrictCountry = $('#register-country').val();
var autocomplete;
function initMap() {
    var options = {
        types: ['establishment'],
        componentRestrictions: {country: restrictCountry},
    };
    var input = document.getElementById('register-address');
    
    autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        var storableLocation = {};
        for (var ac = 0; ac < place.address_components.length; ac++) {
            var component = place.address_components[ac];

            switch(component.types[0]) {
                case 'locality':
                    storableLocation.city = component.long_name;
                    break;
                case 'administrative_area_level_1':
                    storableLocation.state = component.short_name;
                    break;
                case 'country':
                    storableLocation.country = component.long_name;
                    storableLocation.registered_country_iso_code = component.short_name;
                    break;
            }
        };
     
         $('#register-address').val((typeof storableLocation.city!= "undefined"? storableLocation.city+', ':'')+storableLocation.state);
      
        $('#register-lat').val(place.geometry.location.lat());
        $('#register-lng').val(place.geometry.location.lng());
    });
    document.getElementById('register-country').addEventListener('change', setAutocompleteCountry);
    $.get("https://ipinfo.io", function (response) { 
        if($('#register-address').val() == ''){
            $('#register-address').val( response.city);
        }
        let location = response.loc.split(',')
        $('#register-lat').val(location[0]);
        $('#register-lng').val(location[1]);

        if($('#register-country').val() == ''){
            $('#register-country').val(response.country);
        } 
    }, "jsonp");
    
}
function setAutocompleteCountry(){
    var country = document.getElementById('register-country').value;
    autocomplete.setComponentRestrictions({'country': country});
}

function startMap() {
    var options = {
        types: ['(cities)'], 
    };
    var input = document.getElementById('search__address');
    
    autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        var storableLocation = {};
        for (var ac = 0; ac < place.address_components.length; ac++) {
            var component = place.address_components[ac]; 
            switch(component.types[0]) {
                case 'locality':
                    storableLocation.city = component.long_name;
                    break; 
                    case 'administrative_area_level_1':
                    storableLocation.state = component.short_name;
                    break;
                case 'country':
                    storableLocation.country = component.short_name; 
                    break;
            }
        };
    
        $('#search__address').val(storableLocation.country+ ', ' + (typeof storableLocation.city!= "undefined"? storableLocation.city+', ':'')+storableLocation.state);
        
    });
    
}