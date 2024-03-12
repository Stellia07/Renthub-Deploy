@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="page-content">

       
        <div class="row profile-body">
          <!-- left wrapper start -->
          
          <!-- left wrapper end -->
          <!-- middle wrapper start -->
          <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
       
       <div class="card">
    <div class="card-body">
        <h6 class="card-title">Add Property </h6>


            <form method="post" action="{{ route('store.property') }}" id="myForm" enctype="multipart/form-data">
              @csrf


    <div class="row">
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Property Name </label>
                <input type="text" name="property_name" class="form-control"  >
            </div>
        </div><!-- Col -->
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Furnishing Status</label>
                 <select name="furnish_status" class="form-select" id="exampleFormControlSelect1">
                  <option selected="" disabled="">Select Furnishing Status</option>
                  <option value="furnished">Furnished</option>
                  <option value="partially furnished">Partially Furnished</option>
                  <option value="not furnished">Not Furnished</option>
              </select>
            </div>
    </div><!-- Col -->


    <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Rent Price </label>
                <input type="text" name="rent_price" class="form-control"  >
            </div>
        </div><!-- Col -->


            <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Rent Duration </label>
                <input type="text" name="rent_duration" class="form-control"  placeholder="In Months">
            </div>
    </div><!-- Col -->


         <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Main Thumbnail </label>
                <input type="file" name="property_thumbnail" class="form-control" onChange="mainThamUrl(this)"  >

                <img src="" id="mainThmb">

            </div>
        </div><!-- Col -->



         <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Multiple Image </label>
                <input type="file" name="multi_img[]" class="form-control" id="multiImg" multiple="" >
 
         <div class="row" id="preview_img"> </div>

            </div>
        </div><!-- Col -->





    </div><!-- Row -->



    <div class="row">
        <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">BedRooms</label>
                <input type="text" name="bedrooms"  class="form-control" >
            </div>
        </div><!-- Col -->
        <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">Bathrooms</label>
                <input type="text" name="bathrooms"  class="form-control" >
            </div>
        </div><!-- Col -->
        <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">Garage</label>
                 <input type="text" name="garage"  class="form-control" >
            </div>
        </div><!-- Col -->

          <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">Garage Size</label>
                 <input type="text" name="garage_size"  class="form-control" >
            </div>
        </div><!-- Col --> 

        

    </div><!-- Row -->

    
    <div class="mapform">
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">Full Address</label>
                <input type="text" id="address" name="address"  class="form-control" >
                <a href="#" onclick="geocodeAddressLink();">Click here to pin location in map</a>
            </div>
        </div><!-- Col -->
        <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">District</label>
                <!-- <input type="text" name="barangay"  class="form-control" > -->
                <select name="barangay" class="form-select" id="districtdd">
                    <option selected="" disabled="">Select District</option>
                    @foreach($pdistrict as $district)
                    <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- Col -->
        <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city"  class="form-control" >
            </div>
        </div><!-- Col -->

          <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">Province</label>
                 <input type="text" name="province"  class="form-control" >
            </div>
        </div><!-- Col --> 

    </div><!-- Row -->


    <div class="row">
        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Property Size</label>
                <input type="text" name="property_size"  class="form-control" >
            </div>
        </div><!-- Col -->
        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Property Video Youtube Link</label>
                <input type="text" name="property_video"  class="form-control" >
            </div>
        </div><!-- Col -->
        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Postal Code </label>
                 <input type="text" name="postal_code"  class="form-control" >
            </div>
        </div><!-- Col -->
 

    </div><!-- Row -->



    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Latitude</label>
                <input type="text" id="latitude"  name="latitude" class="form-control" >
            </div>
        </div> <!-- Col -->
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="form-control" >
            </div>
        </div> <!-- Col -->

        

        <div id="map" style="height: 400px; width: 100%; margin-bottom: 20px;"></div>

        <script>
            let map;
            let marker;

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 14.599512, lng: 120.984222 },
                    zoom: 18,
                    scrollwheel: true,
                });

                const manila = { lat: 14.599512, lng: 120.984222 };
                marker = new google.maps.Marker({
                    map: map,
                    position: manila,
                    draggable: true
                });

                const addressInput = document.getElementById('address');
                const autocomplete = new google.maps.places.Autocomplete(addressInput, { types: ['geocode'] });

                google.maps.event.addListener(marker, 'position_changed', function () {
                    let lat = marker.position.lat();
                    let lng = marker.position.lng();
                    $('#latitude').val(lat);
                    $('#longitude').val(lng);

                    reverseGeocode(marker.position);
                });

                google.maps.event.addListener(map, 'click', function (event) {
                    marker.setPosition(event.latLng);
                    reverseGeocode(event.latLng);
                });
            }

            function reverseGeocode(location) {
                let geocoder = new google.maps.Geocoder();

                geocoder.geocode({ 'location': location }, function (results, status) {
                    if (status === 'OK') {
                        let address = results[0].formatted_address;
                        $('#address').val(address);

                        updateAdditionalFields(results[0].address_components);
                    } else {
                        alert('Reverse geocode was not successful for the following reason: ' + status);
                    }
                });
            }

            function geocodeAddressLink() {
                let address = document.getElementById('address').value;
                geocodeAddress(address);
            }

            function geocodeAddress(address) {

                if (!address) {
                    alert('Please enter an address.');
                    return;
                }

                let geocoder = new google.maps.Geocoder();

                geocoder.geocode({ 'address': address }, function (results, status) {
                    if (status === 'OK') {
                        let location = results[0].geometry.location;
                        map.setCenter(location);
                        marker.setPosition(location);
                        $('#latitude').val(location.lat());
                        $('#longitude').val(location.lng());

                        updateAdditionalFields(results[0].address_components);
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }

            function updateAdditionalFields(addressComponents) {
                // Define variables to store values temporarily
                let barangay = '';
                let city = '';
                let province = '';
                let postalCode = '';
                let districtId = '';

                // Iterate through the address components and update the values
                addressComponents.forEach(function (component) {
                    if (component.types.includes('sublocality_level_1') || component.types.includes('neighborhood')) {
                        // Barangay
                        districtId  = component.long_name;
                    } else if (component.types.includes('locality')) {
                        // Municipality/District
                        city = component.long_name;
                    } else if (component.types.includes('administrative_area_level_1')) {
                        // Province
                        province = component.long_name;
                    } else if (component.types.includes('postal_code')) {
                        // Postal Code
                        postalCode = component.long_name;
                    }
                });

                // Update the input fields with the obtained values
                $('input[name="barangay"]').val(barangay);
                $('input[name="city"]').val(city);
                $('input[name="province"]').val(province);
                $('input[name="postal_code"]').val(postalCode);

                $('#districtdd').val(districtId);

            }
        </script>

        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtReXZyG8GDdZ-e9hBpPrSbzCNxkM9QE&libraries=places&callback=initMap" type="text/javascript"></script>

        

    </div>


    </div><!-- Row -->

    

    <!-- <div class="row">
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Search Specific Location</label>
                <input type="text" name="mapsearch" class="form-control" >
            </div> -->
        <!-- </div>Col -->
    <!-- </div>Row -->

    <!-- <div class="col-sm-12"> -->
        

        
        
        <!-- <script>
            let map;
            let marker;
            let geocoder;
            let responseDiv;
            let response;

            function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 8,
                center: { lat: -34.397, lng: 150.644 },
                mapTypeControl: false,
            });
            geocoder = new google.maps.Geocoder();

            const inputText = document.createElement("input");

            inputText.type = "text";
            inputText.placeholder = "Enter a location";

            const submitButton = document.createElement("input");

            submitButton.type = "button";
            submitButton.value = "Geocode";
            submitButton.classList.add("button", "button-primary");

            const clearButton = document.createElement("input");

            clearButton.type = "button";
            clearButton.value = "Clear";
            clearButton.classList.add("button", "button-secondary");
            response = document.createElement("pre");
            response.id = "response";
            response.innerText = "";
            responseDiv = document.createElement("div");
            responseDiv.id = "response-container";
            responseDiv.appendChild(response);

            const instructionsElement = document.createElement("p");

            // instructionsElement.id = "instructions";
            // instructionsElement.innerHTML =
            //     "<strong>Instructions</strong>: Enter an address in the textbox to geocode or click on the map to reverse geocode.";
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputText);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(submitButton);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(clearButton);
            map.controls[google.maps.ControlPosition.LEFT_TOP].push(instructionsElement);
            map.controls[google.maps.ControlPosition.LEFT_TOP].push(responseDiv);
            marker = new google.maps.Marker({
                map,
            });
            map.addListener("click", (e) => {
                geocode({ location: e.latLng });
            });
            submitButton.addEventListener("click", () =>
                geocode({ address: inputText.value }),
            );
            clearButton.addEventListener("click", () => {
                clear();
            });
            clear();
            }

            function clear() {
            marker.setMap(null);
            responseDiv.style.display = "none";
            }

            function geocode(request) {
            clear();
            geocoder
                .geocode(request)
                .then((result) => {
                const { results } = result;

                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                marker.setMap(map);
                responseDiv.style.display = "block";
                response.innerText = JSON.stringify(result, null, 2);
                return results;
                })
                .catch((e) => {
                alert("Geocode was not successful for the following reason: " + e);
                });
            }

            window.initMap = initMap;
        </script> -->

        <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtReXZyG8GDdZ-e9hBpPrSbzCNxkM9QE&callback=initMap" type="text/javascript"></script> -->

        <!-- prettier-ignore -->
        <!-- <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
            ({key: "AIzaSyDYtReXZyG8GDdZ-e9hBpPrSbzCNxkM9QE", v: "weekly"});</script>  -->
     <!-- </div>  -->


    <!-- <div class="col-sm-12"> -->
        <!-- <div id="map" style="height: 100%;"></div> -->

        

        <!-- Include the Google Maps JavaScript API -->
        <!-- <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtReXZyG8GDdZ-e9hBpPrSbzCNxkM9QE&callback=initMap">
        </script>     -->
    <!-- </div> -->

    

        <div class="row">
        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Property Type </label>
                <select name="ptype_id" class="form-select" id="exampleFormControlSelect1">
                  <option selected="" disabled="">Select Type</option>
                  @foreach($propertytype as $ptype)

                  <option value="{{ $ptype->id }}">{{ $ptype->type_name }}</option> 

                  @endforeach
                </select>
            </div>
        </div><!-- Col -->
        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Property Amenities </label>
                <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">
                  @foreach($amenities as $ameni)
                  
                  <option value="{{ $ameni->amenities_name }}">{{ $ameni->amenities_name }}</option> 

                  @endforeach
                    
                    
                  </select>
            </div>
        </div><!-- Col -->
        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label"> Owner </label>
                <select name="owner_id" class="form-select" id="exampleFormControlSelect1">
                  <option selected="" disabled="">Select Owner</option>
                  @foreach($activeOwner as $owner)
                  
                  <option value="{{ $owner->id }}">{{ $owner->name }}</option> 

                  @endforeach
                </select>
            </div>
        </div><!-- Col -->
 

    </div><!-- Row -->

    <div class="row">
        <div class="col-sm-6">
          <div class="form-group mb-3">
                <label class="form-label">Valid Id Type</label>
                 <select name="validid_type" class="form-select" id="exampleFormControlSelect1">
                  <option selected="" disabled="">Select Valid Id Type</option>
                  <option value="passport id">Philippine Passport</option>
                  <option value="sss">Social Security System (SSS) Card</option>
                  <option value="drivers license">Driver’s License</option>
                  <option value="postal id">Postal ID</option>
                  <option value="voters id">Voter’s ID</option>
                  <option value="umid">UMID</option>
                  <option value="pwd id">PWD ID</option>
                  <option value="phil-health id">Phil-health ID</option>
              </select>
            </div>
            
        </div><!-- Col -->
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Upload Valid Id</label>
                <input type="file" name="validId_photo" class="form-control" onChange="validIdUrl(this)"  >

                <img src="" id="validId">
            </div>
        </div><!-- Col -->
      </div>


    <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Short Description</label>
                <textarea name="short_desc" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                 
            </div>
        </div><!-- Col -->

        


        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Long Description</label>
                <textarea name="long_desc" class="form-control" name="tinymce" id="tinymceExample" rows="10"></textarea>
                 
            </div>
        </div><!-- Col -->


        <hr>

         <div class="form-group mb-3">
                    <div class="form-check form-check-inline">
        <input type="checkbox" name="featured" value="1" class="form-check-input" id="checkInline1">
                        <label class="form-check-label" for="checkInline1">
                           Featured Property
                        </label>
                    </div>


                 <div class="form-check form-check-inline">
        <input type="checkbox" name="hot" value="1" class="form-check-input" id="checkInline">
                        <label class="form-check-label" for="checkInline">
                            Hot Property
                        </label>
                    </div>


                </div>


                <div class="row add_item">
                        <div class="col-md-4">
                              <div class="form-group mb-3">
                                    <label for="facility_name" class="form-label">Facilities </label>
                                    <input name="facility_name[]" id="facility_name" class="form-control">
                                          
                                    </input>
                              </div>
                        </div>
                        <div class="col-md-4">
                              <div class="form-group mb-3">
                                    <label for="distance" class="form-label"> Distance </label>
                                    <input type="text" name="distance[]" id="distance" class="form-control" placeholder="Distance (Km)">
                              </div>
                        </div>
                        <div class="form-group col-md-4" style="padding-top: 30px;">
                              <a class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i> Add More..</a>
                        </div>
                 </div> <!---end row-->


                 <div class="row add_item">
                        <div class="col-md-4">
                              <div class="form-group mb-3">
                                    <label for="risk_name" class="form-label">Risks </label>
                                    <input name="risk_name[]" id="risk_name" class="form-control">
                                          
                                    </input>
                              </div>
                        </div>
                        
                        <div class="form-group col-md-4" style="padding-top: 30px;">
                              <a class="btn btn-success addeventmorerisk"><i class="fa fa-plus-circle"></i> Add More..</a>
                        </div>
                 </div> <!---end row-->

                 <button type="submit" class="btn btn-primary submit">Save Changes</button>

                    </form>
              
            </div>
        </div>



            </div>
          </div>
          <!-- middle wrapper end -->
          <!-- right wrapper start -->
         
          <!-- right wrapper end -->
        </div>

      </div>


<!--========== Start of add multiple class with ajax ==============-->
<div style="visibility: hidden">
   <div class="whole_extra_item_add" id="whole_extra_item_add">
      <div class="whole_extra_item_delete" id="whole_extra_item_delete">
         <div class="container mt-2">
            <div class="row">
              
               <div class="form-group col-md-4">
                  <label for="facility_name">Facilities</label>
                  <input name="facility_name[]" id="facility_name" class="form-control">
                        
                  </input>
               </div>
               <div class="form-group col-md-4">
                  <label for="distance">Distance</label>
                  <input type="text" name="distance[]" id="distance" class="form-control" placeholder="Distance (Km)">
               </div>
               <div class="form-group col-md-4" style="padding-top: 20px">
                  <span class="btn btn-success btn-sm addeventmore"><i class="fa fa-plus-circle">Add More..</i></span>
                  <span class="btn btn-danger btn-sm removeeventmore"><i class="fa fa-minus-circle">Remove</i></span>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>      


<div style="visibility: hidden">
   <div class="whole_extra_item_add_risk" id="whole_extra_item_add_risk">
      <div class="whole_extra_item_delete_risk" id="whole_extra_item_delete_risk">
         <div class="container mt-2">
            <div class="row">
              
               <div class="form-group col-md-4">
                  <label for="risk_name">Risk</label>
                  <input name="risk_name[]" id="risk_name" class="form-control">
                        
                  </input>
               </div>
               
               <div class="form-group col-md-4" style="padding-top: 20px">
                  <span class="btn btn-success btn-sm addeventmorerisk"><i class="fa fa-plus-circle">Add More..</i></span>
                  <span class="btn btn-danger btn-sm removeeventmorerisk"><i class="fa fa-minus-circle">Remove</i></span>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>      



            <!----For Section-------->
<script type="text/javascript">
   $(document).ready(function(){
      var counter = 0;
      $(document).on("click",".addeventmore",function(){
            var whole_extra_item_add = $("#whole_extra_item_add").html();
            $(this).closest(".add_item").append(whole_extra_item_add);
            counter++;
      });
      $(document).on("click",".removeeventmore",function(event){
            $(this).closest("#whole_extra_item_delete").remove();
            counter -= 1
      });
   });
</script>

<script type="text/javascript">
   $(document).ready(function(){
      var counter = 0;
      $(document).on("click",".addeventmorerisk",function(){
            var whole_extra_item_add_risk = $("#whole_extra_item_add_risk").html();
            $(this).closest(".add_item").append(whole_extra_item_add_risk);
            counter++;
      });
      $(document).on("click",".removeeventmorerisk",function(event){
            $(this).closest("#whole_extra_item_delete_risk").remove();
            counter -= 1
      });
   });
</script>
<!--========== End of add multiple class with ajax ==============--> 


<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                property_name: {
                    required : true,
                },
                property_status: {
                    required : true,
                },
                lowest_price: {
                    required : true,
                },
                max_price: {
                    required : true,
                },
                ptype_id: {
                    required : true,
                },
                multi_img: {
                    required : true,
                },
                property_name: {
                    required : true,
                },
                property_name: {
                    required : true,
                },

                
            },
            messages :{
                property_name: {
                    required : 'Please Enter Property Name',
                }, 
                property_status: {
                    required : 'Please Select Property Status',
                }, 
                lowest_price: {
                    required : 'Please Enter Lowest Price',
                }, 
                max_price: {
                    required : 'Please Enter Max Price',
                }, 
                ptype_id: {
                    required : 'Please Select Property Type',
                }, 
                multi_img: {
                    required : 'Please Insert Multiple Images',
                }, 
                property_name: {
                    required : 'Please Enter Property Name',
                }, 
                property_name: {
                    required : 'Please Enter Property Name',
                }, 
                property_name: {
                    required : 'Please Enter Property Name',
                }, 
                 

            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>


 <script type="text/javascript">
    function mainThamUrl(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
              $('#mainThmb').attr('src',e.target.result).width(80).height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    } 
 </script>

  <script type="text/javascript">
    function validIdUrl(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
              $('#validId').attr('src',e.target.result).width(80).height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    } 
 </script>


 <script> 
 
  $(document).ready(function(){
   $('#multiImg').on('change', function(){ //on file input change
      if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
      {
          var data = $(this)[0].files; //this file data
           
          $.each(data, function(index, file){ //loop though each file
              if(/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file.type)){ //check supported file type
                  var fRead = new FileReader(); //new filereader
                  fRead.onload = (function(file){ //trigger function on successful read
                  return function(e) {
                      var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                  .height(80); //create image element 
                      $('#preview_img').append(img); //append image to output element
                  };
                  })(file);
                  fRead.readAsDataURL(file); //URL representing the file's data.
              }
          });
           
      }else{
          alert("Your browser doesn't support File API!"); //if File API is absent
      }
   });
  });
   
  </script>



@endsection