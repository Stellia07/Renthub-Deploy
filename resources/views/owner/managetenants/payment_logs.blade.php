@extends('owner.owner_dashboard')

@section('owner')
<div class="page-content">
    <h2>My Payment Logs</h2>
    @if ($userPaymentLogs->isEmpty())
        <p>No payment logs found for you.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Amount</th>
                        <th>Recipient Email</th>
                        <th>Sender Email</th>
                        <th>Description</th>
                        <th>Date</th> <!-- Add header for Date -->
                        <th>Receipt Image</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userPaymentLogs as $log)
                    <tr>
                        <td>{{ $log->amount }}</td>
                        <td>{{ $log->recipient_email }}</td>
                        <td>{{ $log->sender_email }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->created_at->format('Y-m-d') }}</td> <!-- Display the date -->
                        <td>
                            @if ($log->receipt_image_path)
                            <button class="btn btn-primary btn-sm" onclick="window.open('{{ asset('storage/' . $log->receipt_image_path) }}')">View Image</button>
                            @else
                            No Image
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
