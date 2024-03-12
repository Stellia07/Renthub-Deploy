<body>
    <br><br><br><br>
    <div class="container">
        <h1>Tenant Dashboard</h1>
        @if($tenantInfo)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Property Name</th>
                    <th>Property Price</th>
                    <th>Owner Name</th>
                    <th>Owner Email</th>
                    <th>Tenant Email</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $tenantInfo->id }}</td>
                    <td>{{ $tenantInfo->property_name }}</td>
                    <td>{{ $tenantInfo->property_price }}</td>
                    <td>{{ $tenantInfo->owner_name }}</td>
                    <td>{{ $tenantInfo->owner_email }}</td>
                    <td>{{ $tenantInfo->tenant_email }}</td>
                    <td>{{ $tenantInfo->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $tenantInfo->updated_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $tenantInfo->status }}</td>
                </tr>
            </tbody>
        </table>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
            Make a Payment
        </button>
        @else
        <p>No tenant information found for your account.</p>
        @endif
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Payment Form -->
                    <form>
                        <div class="mb-3">
                            <label for="paymentAmount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="paymentAmount" placeholder="Enter amount">
                        </div>
                        <div class="mb-3">
                            <label for="paymentReceipt" class="form-label">Upload Receipt</label>
                            <input type="file" class="form-control" id="paymentReceipt">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit Payment</button>
                </div>
            </div>
        </div>
    </div>
</body>
