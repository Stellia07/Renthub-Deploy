@extends('owner.owner_dashboard')

@section('Contract-output')

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        .lease-agreement {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border-collapse: collapse;
        }
        .lease-agreement th, .lease-agreement td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .signature {
            margin-top: 20px;
            line-height: 2;
        }
    </style>
    <br><br><br><br>


    <h1 style="text-align: center;">Lease Agreement</h1>
    
    <table class="lease-agreement">
        <tbody>
            <tr>
                <th>Lessor:</th>
                <td>{{ $data['lessor_name'] }}, residing at {{ $data['lessor_address'] }}</td>
            </tr>
            <tr>
                <th>Lessee:</th>
                <td>{{ $data['lessee_name'] }}, email {{ $data['lessee_email'] }}</td>
            </tr>
            <tr>
                <th>Property Address:</th>
                <td>{{ $data['property_address'] }}</td>
            </tr>
            <tr>
                <th>Lease Term:</th>
                <td>1 year, from {{ $data['start_date'] }} to {{ $data['end_date'] }}</td>
            </tr>
            <tr>
                <th>Monthly Rent:</th>
                <td>{{ $data['rent_amount'] }} due monthly</td>
            </tr>
            <tr>
                <th>Security Deposit:</th>
                <td>Equivalent to three months' rent; two months' rent applied to the last two months of the lease term, and one month's rent held for damages or other dues</td>
            </tr>
            <tr>
                <th>Use of Premises:</th>
                <td>The premises are to be used for residential purposes only</td>
            </tr>
            <tr>
                <th>Utilities:</th>
                <td>Lessee is responsible for all utility payments</td>
            </tr>
            <tr>
                <th>Renewal:</th>
                <td>Notice of intention to renew must be given 7 days before the end of the term</td>
            </tr>
            <tr>
                <th>Subletting:</th>
                <td>Not allowed without Lessor's written consent</td>
            </tr>
            <tr>
                <th>Entry for Inspection:</th>
                <td>Lessor may enter for inspection, repairs, or showing to prospective tenants with reasonable notice</td>
            </tr>
            <tr>
                <th>Termination for Damage:</th>
                <td>Lease may be terminated if premises are substantially damaged by acts of God or other unforeseen events</td>
            </tr>
            <tr>
                <th>End of Lease:</th>
                <td>Lessee must return the premises in good condition, ordinary wear and tear excepted</td>
            </tr>
            <tr>
                <th>Default:</th>
                <td>Lessor may terminate the lease for non-payment of rent and enforce penalties</td>
            </tr>
            <tr>
                <th>Governing Law:</th>
                <td>{{ $data['jurisdiction'] }}</td>
            </tr>
        </tbody>
    </table>

    @endsection