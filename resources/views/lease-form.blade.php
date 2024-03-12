<!-- resources/views/lease-form.blade.php -->

<form action="{{ route('lease.submit') }}" method="POST">
    @csrf
    <div>
        <label>Lessor's Full Name:</label>
        <input type="text" name="lessor_name" required>
    </div>
    <div>
        <label>Lessor's Address:</label>
        <input type="text" name="lessor_address" required>
    </div>
    <div>
        <label>Lessee's Full Name:</label>
        <input type="text" name="lessee_name" required>
    </div>
    <div>
        <label>Lessee's Address:</label>
        <input type="text" name="lessee_address" required>
    </div>
    <div>
        <label>Full Address of Leased Premises:</label>
        <input type="text" name="property_address" required>
    </div>
    <div>
        <label>Start Date:</label>
        <input type="date" name="start_date" required>
    </div>
    <div>
        <label>End Date:</label>
        <input type="date" name="end_date" required>
    </div>
    <div>
        <label>Monthly Rent Amount:</label>
        <input type="text" name="rent_amount" required>
    </div>
    <div>
        <label>Applicable Jurisdiction:</label>
        <input type="text" name="jurisdiction" required>
    </div>
    <div>
        <input type="checkbox" name="lessor_signed" value="1">
        <label>Signed by Lessor</label>
    </div>
    <div>
        <input type="checkbox" name="lessee_signed" value="1">
        <label>Signed by Lessee</label>
    </div>
    
    <button type="submit">Submit</button>
</form>
