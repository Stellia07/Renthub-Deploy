

<div class="container">
    <h1>Submit Test</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('test.store') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Submit Test</button>
    </form>
</div>
