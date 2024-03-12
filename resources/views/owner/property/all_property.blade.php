@extends('owner.owner_dashboard')
@section('owner')

<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      
      <a href="{{ route('owner.add.property') }}" class="btn btn-info">Add Property</a>

    </ol>
  </nav>

  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">All Property</h6>
          <p class="text-muted mb-3">This section is where you will find all Amenities available in our <b>RentHub</b> Website!</p>
          <div class="table-responsive">
            <table id="dataTableExample" class="table">
              <thead>
                <tr>
                  <th>Sl </th>
                  <th>Image </th> 
                  <th>Name </th> 
                  <th>P Type </th> 
                  <th>Furnish Type </th> 
                  <th>Property Code </th> 
                  <th>Owner Name </th> 
                  <th>Status </th>  
                  <th>Action </th> 
                </tr>
              </thead>
              <tbody>

              @foreach($property as $key => $item)  

                <tr>
                  <td>{{ $key+1 }}</td>
                  <td><img src="{{ asset($item->property_thumbnail) }}" style="width: 70px; height: 40px;"></td>
                  <td>{{ $item->property_name }}</td>
                  <td>{{ $item['type']['type_name'] }}</td>
                  <td>{{ $item->furnish_status }}</td>
                  <td>{{ $item->property_code }}</td>
                  <td>{{ $item['owner']['name'] }}</td>
                  <td>

                    @if($item->status == 1)
                      <span class="badge rounded-pill bg-success">Active</span>
                    @else
                      <span class="badge rounded-pill bg-danger">Inactive</span>
                    @endif

                  </td>
                  
                  <td>

                    <a href="{{ route('owner.details.property',$item->id) }}" class="btn btn-outline-info" title="Details"> <i data-feather="eye"></i> </a>
                    <a href="{{ route('owner.edit.property', $item->id) }}" class="btn btn-outline-warning" title="Edit"> <i data-feather="edit"></i></a>
                    <a href="{{ route('owner.delete.property',$item->id) }}" class="btn btn-outline-danger" id="delete" title="Delete"> <i data-feather="trash-2"></i></a>
                  </td>
                  
                </tr>

              @endforeach  
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection