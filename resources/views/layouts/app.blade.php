<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>GitHub Issues Viewer</title>

    <!-- Bootstrap CDN for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('issues.index') }}">
                GitHub Issues Viewer
            </a>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>