@extends('admin.admin_dashboard')
@section('admin')

 <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
          </div>
          <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
              <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
              <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
            </div>
            
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Listed Properties</h6>
                      <div class="dropdown mb-2">
                        
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">{{ $activePropertiesCount }}</h3>
                        
                      </div>
                      <div class="col-6 col-md-12 col-xl-7">
                        <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">New Orders</h6>
                      <div class="dropdown mb-2">
                        
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">35,084</h3>
                        
                      </div>
                      <div class="col-6 col-md-12 col-xl-7">
                        <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Growth</h6>
                      <div class="dropdown mb-2">
                        
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">89.87%</h3>
                        <div class="d-flex align-items-baseline">
                          
                        </div>
                      </div>
                      <div class="col-6 col-md-12 col-xl-7">
                        <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- row -->

        

        <div class="row">
          <div class="col-lg-12 col-xl-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0">Monthly Listings</h6>
                  <div class="dropdown mb-2">
                    
                  </div>
                </div>
                <p class="text-muted">Sales are activities related to selling or the number of goods or services sold in a given time period.</p>
                <div id="monthlySalesChart"></div>
              </div> 
            </div>
          </div>
          
        </div> <!-- row -->

        <div class="row">
          <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0">Inbox</h6>
                  <div class="dropdown mb-2">
                    
                  </div>
                </div>
                <div class="d-flex flex-column">
                  <a href="javascript:;" class="d-flex align-items-center border-bottom pb-3">
                    <div class="me-3">
                      <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                    </div>
                    <div class="w-100">
                      <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">Leonardo Payne</h6>
                        <p class="text-muted tx-12">12.30 PM</p>
                      </div>
                      <p class="text-muted tx-13">Hey! there I'm available...</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                    <div class="me-3">
                      <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                    </div>
                    <div class="w-100">
                      <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">Carl Henson</h6>
                        <p class="text-muted tx-12">02.14 AM</p>
                      </div>
                      <p class="text-muted tx-13">I've finished it! See you so..</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                    <div class="me-3">
                      <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                    </div>
                    <div class="w-100">
                      <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">Jensen Combs</h6>
                        <p class="text-muted tx-12">08.22 PM</p>
                      </div>
                      <p class="text-muted tx-13">This template is awesome!</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                    <div class="me-3">
                      <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                    </div>
                    <div class="w-100">
                      <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">Amiah Burton</h6>
                        <p class="text-muted tx-12">05.49 AM</p>
                      </div>
                      <p class="text-muted tx-13">Nice to meet you</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                    <div class="me-3">
                      <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                    </div>
                    <div class="w-100">
                      <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-2">Yaretzi Mayo</h6>
                        <p class="text-muted tx-12">01.19 AM</p>
                      </div>
                      <p class="text-muted tx-13">Hey! there I'm available...</p>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-7 col-xl-8 stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h6 class="card-title mb-0">All Properties</h6>
                  <div class="dropdown mb-2">
                    
                  </div>
                </div>
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th>Sl </th>
                        <th>Name </th> 
                        <th>P Type </th> 
                        <th>Furnish Type </th> 
                        <th>Property Code </th> 
                        <th>Owner Name </th> 
                        <th>Status </th>  
                      </tr>
                    </thead>
                    <tbody>

                    @foreach($property as $key => $item)	

                      <tr>
                        <td>{{ $key+1 }}</td>
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
                        
                        
                        
                      </tr>

                    @endforeach  
                      
                    </tbody>
                  </table>
                </div>
              </div> 
            </div>
          </div>
        </div> <!-- row -->

      </div>

@endsection