<style>
    body {
    font-family: 'Roboto', sans-serif;
    color: #333;
    background-color: #f4f4f4;
}

h1, h2, h3 {
    font-family: 'Georgia', serif;
}

.form-control {
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
    width: 100%;
}

.btn-primary {
    background-color: #0056b3;
    border: none;
    padding: 10px 15px;
    color: white;
    border-radius: 4px;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-primary:hover {
    background-color: #004494;
}

.alert {
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

</style>


@if(session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger" role="alert">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container mt-4">
    <h1 class="mb-4">Rent Property: {{ $property->property_name }}</h1>

    <form action="{{ route('submit-tenant') }}" method="POST" class="needs-validation" novalidate>
        @csrf <!-- CSRF token for security -->

        <div class="form-group mb-3">
            <label for="property_name" class="form-label">Property Name</label>
            <input type="text" class="form-control" id="property_name" name="property_name" value="{{ old('property_name', $property->property_name) }}" required>
            <div class="invalid-feedback">
                Please provide the property name.
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="property_price" class="form-label">Property Price</label>
            <input type="text" class="form-control" id="property_price" name="property_price" value="{{ old('property_price', $property->rent_price) }}" required>
            <div class="invalid-feedback">
                Please provide the property price.
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="owner_name" class="form-label">Owner Name</label>
            <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ old('owner_name', $property->owner->name) }}" required>
            <div class="invalid-feedback">
                Please provide the owner's name.
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="owner_email" class="form-label">Owner Email</label>
            <input type="email" class="form-control" id="owner_email" name="owner_email" value="{{ old('owner_email', $property->owner->email) }}" required>
            <div class="invalid-feedback">
                Please provide the owner's email address.
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="tenant_email" class="form-label">Tenant Email</label>
            <input type="email" class="form-control" id="tenant_email" name="tenant_email" value="{{ old('tenant_email', $user->email ?? '') }}" required>
            <div class="invalid-feedback">
                Please provide your email address.
            </div>
        </div>

        <!-- Add other fields as necessary -->

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>

</div>
