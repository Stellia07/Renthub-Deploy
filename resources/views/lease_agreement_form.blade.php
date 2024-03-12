@extends('owner.owner_dashboard')

@section('Contract')
<br><br>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Lease Agreement Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('lease.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="lessor_name" class="form-label">Lessor's Full Name:</label>
                                <input type="text" class="form-control" name="lessor_name" id="lessor_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="lessor_address" class="form-label">Lessor's Address:</label>
                                <input type="text" class="form-control" name="lessor_address" id="lessor_address" required>
                            </div>
                            <div class="mb-3">
                                <label for="lessee_name" class="form-label">Lessee's Full Name:</label>
                                <input type="text" class="form-control" name="lessee_name" id="lessee_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="lessee_address" class="form-label">Lessee's Email:</label>
                                <input type="text" class="form-control" name="lessee_email" id="lessee_email" required>

                            </div>
                            <div class="mb-3">
                                <label for="property_address" class="form-label">Full Address of Leased Premises:</label>
                                <input type="text" class="form-control" name="property_address" id="property_address" required>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date:</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date:</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="rent_amount" class="form-label">Monthly Rent Amount:</label>
                                <input type="text" class="form-control" name="rent_amount" id="rent_amount" required>
                            </div>
                            <div class="mb-3">
                                <label for="jurisdiction" class="form-label">Applicable Jurisdiction:</label>
                                <input type="text" class="form-control" name="jurisdiction" id="jurisdiction" required>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" name="lessor_signed" id="lessor_signed" value="1">
                                <label class="form-check-label" for="lessor_signed">Signed by Lessor</label>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" name="lessee_signed" id="lessee_signed" value="1">
                                <label class="form-check-label" for="lessee_signed">Signed by Lessee</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
@endsection
