@extends('owner.owner_dashboard')

@section('owner')
    <style>
        .modal-lg {
            max-width: 95% !important;
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Additional styles for a more formal appearance */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .form-label {
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .submit-btn {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
    @php
        $isAdmin = Auth::check() && Auth::user()->role === 'owner';
    @endphp

    <div class="page-content">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Property Name</th>
                    <th>Property Price</th>
                    <th>Tenant Email</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Contract</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tenants as $tenant)
                    <tr>
                        <td>{{ $tenant->id }}</td>
                        <td>{{ $tenant->property_name }}</td>
                        <td>{{ $tenant->property_price }}</td>
                        <td>{{ $tenant->tenant_email }}</td>
                        <td>{{ ucfirst($tenant->status) }}</td>
                        <td>{{ $tenant->created_at }}</td>
                        @if ($isAdmin)
                            <td>
                                <!-- Check if tenant email exists in lease-agreement table -->
                                @if (\App\Models\LeaseAgreement::where('lessee_email', $tenant->tenant_email)->exists())
                                    <!-- Button to view contract -->
                                    <button type="button" class="btn btn-primary view-contract-btn"
                                        data-tenant-email="{{ $tenant->tenant_email }}">
                                        View Contract
                                    </button>
                                @else
                                    <!-- Button to open lessor form -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#lessorFormModal">
                                        Open Lessor Form
                                    </button>
                                @endif
                            </td>
                        @endif
                        <td>
                            <!-- New "Bills" button to open modal -->
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#tenantDetailsModal{{ $tenant->id }}">Bills</button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        @foreach ($tenants as $tenant)
            @php
                $user = \App\Models\User::where('email', $tenant->tenant_email)->first();
            @endphp


            <!-- Modal for Tenant Details -->
            <div class="modal fade" id="tenantDetailsModal{{ $tenant->id }}" tabindex="-1"
                aria-labelledby="tenantDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tenantDetailsModalLabel">Tenant Payment Details -
                                {{ $tenant->tenant_email }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($user && $user->status == 'inactive')
                                <!-- If user is inactive, show 'Paid' button -->
                                <form action="{{ route('changeUserStatus', $tenant->tenant_email) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Paid</button>

                                </form>
                            @else
                                @php
                                    $electricity = $tenant->electricityBilling
                                        ->where('tenant_email', $tenant->tenant_email)
                                        ->first();
                                    $water = $tenant->waterBilling
                                        ->where('tenant_email', $tenant->tenant_email)
                                        ->first();
                                    $rent = $tenant->rentBilling->where('tenant_email', $tenant->tenant_email)->first();
                                @endphp

<table class="table">
    <thead>
        <tr>
            <th>Type</th>
            <th>Previous Reading</th>
            <th>New Reading</th>
            <th>Price Per Unit</th>
            <th>Amount Due</th>
            <th>Balance</th>
            <th>Payment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Start of Electricity Billing Row -->
        <tr class="utility-row">
            <form action="{{ route('update.billing', $tenant->id) }}" method="POST">
                @csrf
                <td>Electricity</td>
                <td>{{ $electricity->previous_reading ?? '0' }} kWh</td>
                <td><input type="number" name="new_reading" class="form-control" placeholder="Enter new reading"></td>
                <td>${{ $electricity->price_per_unit ?? '0.15' }}</td>
                <td>${{ $electricity->amount_due ?? '0.00' }}</td>
                <td>${{ $electricity->balance ?? '0.00' }}</td>
                <td><input type="number" name="payment" class="form-control" placeholder="Enter payment"></td>
                <td><button type="submit" class="btn btn-primary">Update Electricity</button></td>
            </form>
        </tr>
        <!-- End of Electricity Billing Row -->
        
        <!-- Start of Water Billing Row -->
        <tr class="utility-row">
            <form action="{{ route('update.water.billing', $tenant->id) }}" method="POST">
                @csrf
                <td>Water</td>
                <td>{{ $water->previous_reading ?? '0' }} m³</td>
                <td><input type="number" name="new_water_reading" class="form-control" placeholder="Enter new water reading"></td>
                <td>${{ $water->price_per_unit ?? '0.10' }}</td>
                <td>${{ $water->amount_due ?? '0.00' }}</td>
                <td>${{ $water->balance ?? '0.00' }}</td>
                <td><input type="number" name="water_payment" class="form-control" placeholder="Enter water payment"></td>
                <td><button type="submit" class="btn btn-primary">Update Water</button></td>
            </form>
        </tr>
        <!-- End of Water Billing Row -->

        <!-- Start of Rent Billing Section -->
        <tr>
            <td colspan="8">
                <form action="{{ route('update.rent.billing', $tenant->id) }}" method="POST">
                    @csrf
                    <h5>Rent Billing</h5>
                    <table class="table">
                        <tr>
                            <td>Monthly Rent:</td>
                            <td>${{ $rent->monthly_rent ?? '0.00' }}</td>
                        </tr>
                        <tr>
                            <td>Current Balance:</td>
                            <td>${{ $rent->balance ?? '0.00' }}</td>
                        </tr>
                        <tr>
                            <td>Payment:</td>
                            <td><input type="number" name="rent_payment" class="form-control" placeholder="Enter payment amount"></td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-primary">Pay Rent</button>
                </form>
            </td>
        </tr>
        <!-- End of Rent Billing Section -->
    </tbody>
</table>


                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @php
                $isOwner = Auth::check() && Auth::user()->role === 'owner';
            @endphp

            <!-- Lessor Form Modal -->
            <!-- Lessor Form Modal -->
            

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const lessorSignedCheckbox = document.getElementById('lessorSignedCheckbox');
                        const contractCreationButton = document.getElementById('contractCreationButton');

                        if (lessorSignedCheckbox) {
                            lessorSignedCheckbox.addEventListener('change', function() {
                                if (this.checked) {
                                    contractCreationButton.style.display = 'block';
                                } else {
                                    contractCreationButton.style.display = 'none';
                                }
                            });
                        }
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Example: Adding event listeners to each tenant row for selection.
                        document.querySelectorAll('.tenant-row').forEach(row => {
                            row.addEventListener('click', function() {
                                // Extract tenant information
                                const lesseeName = this.dataset.lesseeName;
                                const lesseeAddress = this.dataset.lesseeAddress ||
                                    'test'; // Default to 'test' if no address

                                // Autofill the form
                                document.querySelector('input[name="lessee_name"]').value = lesseeName;
                                document.querySelector('input[name="lessee_address"]').value = lesseeAddress;
                            });
                        });
                    });
                </script>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Get all the buttons with the 'View Contract' class
                        const viewContractButtons = document.querySelectorAll('.view-contract-btn');

                        // Add click event listener to each button
                        viewContractButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                // Get the tenant email from the data attribute
                                const tenantEmail = this.dataset.tenantEmail;

                                // Redirect to the route with the tenant's email
                                window.location.href = `/view-contract/${tenantEmail}`;
                            });
                        });
                    });
                </script>


                <!-- End Tenant Details Modal -->
        @endforeach
    </div>
@endsection
