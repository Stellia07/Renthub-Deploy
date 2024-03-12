@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">

	<nav class="page-breadcrumb">
		<ol class="breadcrumb">
			
			<a href="{{ route('add.amenity') }}" class="btn btn-info">Add Amenites</a>

		</ol>
	</nav>

	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
    <h6 class="card-title">All Amenities</h6>
    <p class="text-muted mb-3">This section is where you will find all Amenities available in our <b>RentHub</b> Website!</p>
    <div class="table-responsive">
      <table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th>Sl </th>
            <th>Amenity Name </th>
            <th>Action </th>
          </tr>
        </thead>
        <tbody>

        @foreach($amenities as $key => $item)	

          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $item->amenities_name }}</td>
            <td>

            	<a href="{{ route('edit.amenity', $item->id) }}" class="btn btn-outline-warning">Edit</a>
            	<a href="{{ route('delete.amenity', $item->id) }}" class="btn btn-outline-danger" id="delete">Delete</a>

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