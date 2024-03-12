@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="page-content">

<div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                                <h6 class="card-title">Property Details </h6>
                                
                                <div class="table-responsive">
        <table class="table table-striped">

            <tbody>
                <tr> 
                    <td>Property Name </td>
                    <td><code>{{ $property->property_name }}</code></td> 
                </tr>

                <tr> 
                    <td>Property Status </td>
                    <td><code>{{ $property->property_status }}</code></td> 
                </tr>

                <tr> 
                    <td>Furnishing Status </td>
                    <td><code>{{ $property->furnish_status }}</code></td> 
                </tr>

                <tr> 
                    <td>Rent Price </td>
                    <td><code>{{ $property->rent_price }}</code></td> 
                </tr>

                <tr> 
                    <td>Rent Duration </td>
                    <td><code>{{ $property->rent_duration }}</code></td> 
                </tr>

                <tr> 
                    <td>BedRooms </td>
                    <td><code>{{ $property->bedrooms }}</code></td> 
                </tr>

                <tr> 
                    <td>Bathrooms </td>
                    <td><code>{{ $property->bathrooms }}</code></td> 
                </tr>

                <tr> 
                    <td>Garage </td>
                    <td><code>{{ $property->garage }}</code></td> 
                </tr>

                <tr> 
                    <td>Garage Size </td>
                    <td><code>{{ $property->garage_size }}</code></td> 
                </tr>

                <tr> 
                    <td>Full Address </td>
                    <td><code>{{ $property->address }}</code></td> 
                </tr>

                <tr> 
                    <td>District </td>
                    
                    <td><code>{{ $property->barangay }}</code></td> 
                </tr>

                <tr> 
                    <td>City </td>
                    <td><code>{{ $property->city }}</code></td> 
                </tr>

                <tr> 
                    <td>Province </td>
                    <td><code>{{ $property->province }}</code></td> 
                </tr>

                <tr> 
                    <td>Postal Code </td>
                    <td><code>{{ $property->postal_code }}</code></td> 
                </tr>

                <tr> 
                    <td>Thumbnail </td>
                    <td>
                    <img src="{{ asset($property->property_thumbnail) }}" style="width:100px; height:70px;">
                    </td>
                </tr>

                <tr> 
                    <td>Status </td>
                    <td>
                        @if($property->status == 1)
                        <span class="badge rounded-pill bg-success">Active</span>
                        @else
                        <span class="badge rounded-pill bg-danger">Inactive</span>
                        @endif
                    </td> 
                </tr>

            </tbody>
        </table>
                                </div>
              </div>
            </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                               
                                
                    <div class="table-responsive">
                            <table class="table table-striped">
                                
                                <tbody>
                                    <tr> 
                                        <td>Property Code </td>
                                        <td><code>{{ $property->property_code }}</code></td>
                                    </tr>

                                    <tr> 
                                        <td>Property Size </td>
                                        <td><code>{{ $property->property_size }}</code></td> 
                                    </tr>

                                    <tr> 
                                        <td>Property Video</td>
                                        <td><code>{{ $property->property_video }}</code></td> 
                                    </tr>

                                    <tr> 
                                        <td>Latitude </td>
                                        <td><code>{{ $property->latitude }}</code></td> 
                                    </tr>

                                    <tr> 
                                        <td>Longitude </td>
                                        <td><code>{{ $property->longitude }}</code></td> 
                                    </tr>

                                    <tr> 
                                        <td>Property Type </td>
                                        <td><code>{{ $property['type']['type_name'] }}</code></td> 
                                    </tr>

                                    <tr> 
                                        <td>Property Amenities </td>
                                        <td>
                                            <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">

                                            @foreach($amenities as $ameni)
                                            <option value="{{ $ameni->amenities_name }}" {{ (in_array($ameni->amenities_name,$property_ami)) ? 'selected' : '' }} >{{ $ameni->amenities_name }}</option>
                                            @endforeach

                                            </select>
                                        </td> 
                                    </tr>

                                    <tr>
                                        <td>Owner Name</td>
                                        <td>
                                            @if($property->owner_id == NULL)
                                            <code>Admin</code>
                                            @else
                                            <code>{{ $property['user']['name'] }}</code>
                                            @endif

                                        </td>
                                    </tr>

                                    <tr> 
                                        <td>Valid ID Type </td>
                                        <td><code>{{ $property->validid_type }}</code></td> 
                                    </tr>

                                    <tr> 
                                        <td>Valid Id Photo </td>
                                        <td>
                                            <a data-toggle="modal" data-target="#imageModal">
                                            <img src="{{ asset($property->validId_photo) }}" style="width:100px; height:70px;">
                                            </a>
                                        </td>
                                    </tr>


                                    
                                </tbody>
                            </table>

                            <br><br>
                                     @if($property->status == 1)
                              <form method="post" action="{{ route('inactive.property') }}" >
                                            @csrf
                                <input type="hidden" name="id" value="{{ $property->id }}">
                               <button type="submit" class="btn btn-danger">Deactivate </button>

                            </form>

                                     @else

                                 <form method="post" action="{{ route('active.property') }}" >
                                            @csrf
                              <input type="hidden" name="id" value="{{ $property->id }}">

                               <button type="submit" class="btn btn-success">Activate </button>

                            </form>

                                     @endif 



                    </div>
              </div>
            </div>
                    </div>
                </div>
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Valid Id Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ asset($property->validId_photo) }}" class="img-fluid">
            </div>
        </div>
    </div>
</div>


  </div>







@endsection