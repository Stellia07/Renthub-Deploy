@extends('tenant.tenant_dashboard')

@section('tenant')
<br><br><br>
<div class="container">
    <h1>Submit Payment</h1>
    <form action="{{ route('payment-log.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" class="form-control" name="amount" id="amount" required>
        </div>
        <div class="form-group">
            <label for="receipt_image_path">Receipt Image:</label>
            <input type="file" class="form-control" name="receipt_image_path" id="receipt_image_path" required>
        </div>
        <div class="form-group">
            <label for="recipient_email">Recipient Email:</label>
            <input type="email" class="form-control" name="recipient_email" id="recipient_email" required>
        </div>
        <div class="form-group">
            <label for="sender_email">Sender Email:</label>
            <!-- Autofill the sender email with the logged-in user's email -->
            <input type="email" class="form-control" name="sender_email" id="sender_email" value="{{ Auth::user()->email }}" readonly>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
