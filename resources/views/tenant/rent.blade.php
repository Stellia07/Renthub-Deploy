@extends('tenant.tenant_dashboard')

@section('tenant')
<br><br><br>
<div class="container">
    <h2>Rent Billing</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tenant Email</th>
                <th>Monthly Rent</th>
                <th>Balance</th>
                <th>Last Payment Date</th>
                <th>Last Payment Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rentBillings as $billing)
            <tr>
                <td>{{ $billing->tenant_email }}</td>
                <td>{{ $billing->monthly_rent }}</td>
                <td>{{ $billing->balance }}</td>
                <td>{{ $billing->last_payment_date }}</td>
                <td>{{ $billing->last_payment_amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
