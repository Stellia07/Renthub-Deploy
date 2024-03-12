<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
  <meta name="author" content="NobleUI">
  <meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

  <title>Admin Panel - Renthub</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

  <link rel="stylesheet" href="{{ asset('backend/assets/vendors/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/vendors/jquery-tags-input/jquery.tagsinput.min.css') }}">

  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
  <!-- End plugin css for this page -->

  <!-- core:css -->
  <link rel="stylesheet" href="{{ asset('backend/assets/vendors/core/core.css') }}">
  <!-- endinject -->

  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.css') }}">
  <!-- End plugin css for this page -->

  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather-font/css/iconfont.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
  <!-- endinject -->

  <!-- Layout styles -->  
  <link rel="stylesheet" href="{{ asset('backend/assets/css/demo2/style.css') }}">
  <!-- End layout styles -->

  <link rel="shortcut icon" href="{{ asset('backend/assets/images/renthubIC.png') }}" />

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
  
  <style>
    /* 
 * Always set the map height explicitly to define the size of the div element
 * that contains the map. 
 */
#map {
  height: 100%;
}

/* 
 * Optional: Makes the sample page fill the window. 
 */
/* html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
} */

/* input[type=text] {
  background-color: #fff;
  border: 0;
  border-radius: 2px;
  box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
  margin: 10px;
  padding: 0 0.5em;
  font: 400 18px Roboto, Arial, sans-serif;
  overflow: hidden;
  line-height: 40px;
  margin-right: 0;
  min-width: 25%;
} */

input[type=button] {
  background-color: #fff;
  border: 0;
  border-radius: 2px;
  box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
  margin: 10px;
  padding: 0 0.5em;
  font: 400 18px Roboto, Arial, sans-serif;
  overflow: hidden;
  height: 40px;
  cursor: pointer;
  margin-left: 5px;
}
input[type=button]:hover {
  background: rgb(235, 235, 235);
}
input[type=button].button-primary {
  background-color: #1a73e8;
  color: white;
}
input[type=button].button-primary:hover {
  background-color: #1765cc;
}
input[type=button].button-secondary {
  background-color: white;
  color: #1a73e8;
}
input[type=button].button-secondary:hover {
  background-color: #d2e3fc;
}

#response-container {
  background-color: #fff;
  border: 0;
  border-radius: 2px;
  box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
  margin: 10px;
  padding: 0 0.5em;
  font: 400 18px Roboto, Arial, sans-serif;
  overflow: hidden;
  overflow: auto;
  max-height: 50%;
  max-width: 90%;
  background-color: rgba(255, 255, 255, 0.95);
  font-size: small;
}

#instructions {
  background-color: #fff;
  border: 0;
  border-radius: 2px;
  box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
  margin: 10px;
  padding: 0 0.5em;
  font: 400 18px Roboto, Arial, sans-serif;
  overflow: hidden;
  padding: 1rem;
  font-size: medium;
}
  </style>

</head>
<body>
  <div class="main-wrapper">

    <!-- partial:partials/_sidebar.html -->
   @include('admin.body.sidebar')
    
    <!-- partial -->
  
    <div class="page-wrapper">
          
      <!-- partial:partials/_navbar.html -->
     @include('admin.body.header')
      <!-- partial -->

     @yield('admin')

      <!-- partial:partials/_footer.html -->
    @include('admin.body.footer')
      <!-- partial -->
    
    </div>
  </div>

  <!-- core:js -->
  <script src="{{ asset('backend/assets/vendors/core/core.js') }}"></script>
  <!-- endinject -->

  <!-- Plugin js for this page -->
  <script src="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
  <!-- End plugin js for this page -->

  <!-- inject:js -->
  <script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/template.js') }}"></script>
  <!-- endinject -->

  <!-- Custom js for this page -->
  <script src="{{ asset('backend/assets/js/dashboard-dark.js') }}"></script>
  <!-- End custom js for this page -->

  <!-- maps api -->
  <!-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?AIzaSyDYtReXZyG8GDdZ-e9hBpPrSbzCNxkM9QE&callback=initMap">

  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

  

  </script> -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtReXZyG8GDdZ-e9hBpPrSbzCNxkM9QE"></script> -->

  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtReXZyG8GDdZ-e9hBpPrSbzCNxkM9QE&callback=initMap" type="text/javascript"></script>
  <script src="{{ asset('frontend/assets/js/gmaps.js') }}"></script>
  <script src="{{ asset('frontend/assets/js/map-helper.js') }}"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    // Initialize and add the map
    let map;
    let marker;

    async function initMap() {
        // The location of Uluru
        const initialPosition = { lat: -25.344, lng: 131.031 };
        // Request needed libraries.
        //@ts-ignore
        const { Map, Marker, places } = await google.maps.importLibrary("maps", "marker", "places");

        // The map, centered at Uluru
        map = new Map(document.getElementById("map"), {
            zoom: 4,
            center: initialPosition,
            mapId: "DEMO_MAP_ID",
        });

        // The marker, positioned at Uluru
        marker = new Marker({
            map: map,
            position: initialPosition,
            title: "Uluru",
        });

        // Create the search box and link it to the external input.
        const input = document.getElementById("mapsearch");
        const searchBox = new places.Autocomplete(input);

        // Bias the SearchBox results towards the map's viewport.
        map.addListener("bounds_changed", function () {
            searchBox.setBounds(map.getBounds());
        });

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("place_changed", function () {
            const place = searchBox.getPlace();

            if (!place.geometry) {
                console.error("Returned place contains no geometry");
                return;
            }

            // Clear out the old marker.
            marker.setMap(null);

            // Set the new marker at the selected place.
            marker.setPosition(place.geometry.location);
            map.panTo(place.geometry.location);
            map.setZoom(15); // You can adjust the zoom level as needed.
        });
    }

    initMap();
</script>


<script>
  let autocomplete;
  function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('autocomplete'),
      {
        types: ['establishment'],
        componentRestrictions: {'country': ['PH']},
        fields: ['place_id', 'geometry', 'name']
      });

      autocomplete.addListener('place_change', onPlaceChanged);

  }

  function onPlaceChanged() {

    var place = autocomplete.getPlace();

    if(!place.geometry) {
      document.getElementById('autocomplete').placeholder = 'Enter a place';
    } else {
      document.getElementById('details').innerHTML = place.name;
    }

  }

</script>



  <script>
   @if(Session::has('message'))
   var type = "{{ Session::get('alert-type','info') }}"
   switch(type){
      case 'info':
      toastr.info(" {{ Session::get('message') }} ");
      break;

      case 'success':
      toastr.success(" {{ Session::get('message') }} ");
      break;

      case 'warning':
      toastr.warning(" {{ Session::get('message') }} ");
      break;

      case 'error':
      toastr.error(" {{ Session::get('message') }} ");
      break; 
   }
   @endif 
  </script>
  

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="{{ asset('backend/assets/js/code/code.js') }}"></script>
  <script src="{{ asset('backend/assets/js/code/validate.min.js') }}"></script>


  <!-- Start DataTables -->
  <script src="{{ asset('backend/assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>

  <script src="{{ asset('backend/assets/js/data-table.js') }}"></script>
  <!-- End DataTables -->


  <script src="{{ asset('backend/assets/vendors/select2/select2.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendors/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>

  <script src="{{ asset('backend/assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('backend/assets/js/select2.js') }}"></script>
  <script src="{{ asset('backend/assets/js/typeahead.js') }}"></script>
  <script src="{{ asset('backend/assets/js/tags-input.js') }}"></script>


  <script src="{{ asset('backend/assets/vendors/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/tinymce.js') }}"></script>

  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

</body>
</html>    