<!-- resources/views/not-authorized.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Not Authorized</title>
</head>
<body>
    <div class="container">
        <h1>Access Denied</h1>

        <!-- Display error message if available -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
</body>
</html>
