@extends('tenant.tenant_dashboard') {{-- Use your layout --}}

@section('tenant')
<br><br><br>
<div class="container">
    <h1>Water Billing</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Tenant Email</th>
                <th>Overall Usage</th>
                <th>Previous Reading</th>
                <th>New Reading</th>
                <th>Price per Unit</th>
                <th>Amount Due</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($waterBillings as $billing)
            <tr>
                <td>{{ $billing->tenant_email }}</td>
                <td>{{ $billing->overall_usage }}</td>
                <td>{{ $billing->previous_reading }}</td>
                <td>{{ $billing->new_reading }}</td>
                <td>{{ $billing->price_per_unit }}</td>
                <td>{{ $billing->amount_due }}</td>
                <td>{{ $billing->balance }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
