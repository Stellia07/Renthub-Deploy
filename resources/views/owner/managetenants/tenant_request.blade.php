@extends('owner.owner_dashboard')

@section('owner')

<div class="page-content">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Property Name</th>
                <th>Property Price</th>
                <th>Owner Name</th>
                <th>Owner Email</th>
                <th>Tenant Email</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tenants as $tenant)
            <tr>
                <td>{{ $tenant->id }}</td>
                <td>{{ $tenant->property_name }}</td>
                <td>{{ $tenant->property_price }}</td>
                <td>{{ $tenant->owner_name }}</td>
                <td>{{ $tenant->owner_email }}</td>
                <td>{{ $tenant->tenant_email }}</td>
                <td>{{ ucfirst($tenant->status) }}</td>
                <td>{{ $tenant->created_at }}</td>
                <td>{{ $tenant->updated_at }}</td>
                <td>
                    @if($tenant->status == 'pending')
                    <!-- Accept Button -->
                    <form method="POST" action="{{ route('tenant.accept', $tenant) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Accept
                        </button>
                    </form>

                    <!-- Reject Button -->
                    <form method="POST" action="{{ route('tenant.reject', $tenant) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Reject
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection