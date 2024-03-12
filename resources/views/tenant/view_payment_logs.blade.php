@extends('tenant.tenant_dashboard')

@section('tenant')
<br><br><br>
<div class="container">
    <h2>My Payment Logs</h2>
    @if ($myPaymentLogs->isEmpty())
        <p>No payment logs found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Recipient Email</th>
                    <th>Sender Email</th>
                    <th>Description</th>
                    <th>Date</th> <!-- Add a header for Date -->
                    <th>Receipt Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($myPaymentLogs as $log)
                <tr>
                    <td>{{ $log->amount }}</td>
                    <td>{{ $log->recipient_email }}</td>
                    <td>{{ $log->sender_email }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->created_at->format('Y-m-d') }}</td> <!-- Display the date -->
                    <td>
                        @if ($log->receipt_image_path)
                            <a href="{{ asset('storage/' . $log->receipt_image_path) }}" target="_blank">View Image</a>
                        @else
                            No Image
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
