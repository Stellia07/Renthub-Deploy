{{-- create.blade.php --}}

    <h1>Create Payment Log</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('payment-log.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Amount:</label>
            <input type="number" name="amount" required>
        </div>
        <div>
            <label>Receipt Image:</label>
            <input type="file" name="receipt_image_path" required>
        </div>
        <div>
            <label>Recipient Email:</label>
            <input type="email" name="recipient_email" required>
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description" required></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>
    <h2>Existing Payment Logs</h2>
<table>
    <tr>
        <th>Amount</th>
        <th>Recipient Email</th>
        <th>Description</th>
        <th>Receipt Image</th>
        <!-- Add other relevant fields -->
    </tr>
    @foreach ($paymentLogs as $log)
    <tr>
        <td>{{ $log->amount }}</td>
        <td>{{ $log->recipient_email }}</td>
        <td>{{ $log->description }}</td>
        <td>
            @if ($log->receipt_image_path)
            <button onclick="window.open('{{ asset('storage/' . $log->receipt_image_path) }}')">View Image</button>
            @else
            No Image
            @endif
        </td>
        <!-- Display other relevant fields -->
    </tr>
    @endforeach
</table>

<h2>My Payment Logs</h2>
@if ($userPaymentLogs->isEmpty())
    <p>No payment logs found for you.</p>
@else
    <table>
        <tr>
            <th>Amount</th>
            <th>Recipient Email</th>
            <th>Description</th>
            <th>Receipt Image</th>
            <!-- Add other relevant fields -->
        </tr>
        @foreach ($userPaymentLogs as $log)
        <tr>
            <td>{{ $log->amount }}</td>
            <td>{{ $log->recipient_email }}</td>
            <td>{{ $log->description }}</td>
            <td>
                @if ($log->receipt_image_path)
                <button onclick="window.open('{{ asset('storage/' . $log->receipt_image_path) }}')">View Image</button>
                @else
                No Image
                @endif
            </td>
            <!-- Display other relevant fields -->
        </tr>
        @endforeach
    </table>
@endif
