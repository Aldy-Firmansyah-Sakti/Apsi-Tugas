<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café X - Redirecting...</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <script>
        // Redirect to customer welcome page
        window.location.href = "{{ route('home') }}";
    </script>
</body>
</html>