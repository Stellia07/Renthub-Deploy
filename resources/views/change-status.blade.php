<!DOCTYPE html>
<html>
<head>
    <title>Change User Status</title>
</head>
<body>
    <h1>Change User Status</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('changeUserStatus') }}" method="POST">
        @csrf
        <button type="submit">Change Status of basicuser1@gmail.com</button>
    </form>
</body>
</html>
