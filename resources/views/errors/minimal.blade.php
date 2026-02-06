<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name', 'My Idlers') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #212529;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-color: #1a1d21;
                --card-bg: #212529;
                --text-color: #e9ecef;
                --text-muted: #adb5bd;
                --border-color: #495057;
            }
        }
        html, body {
            height: 100%;
            margin: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .error-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .error-code {
            font-size: 5rem;
            font-weight: 700;
            color: var(--text-muted);
            line-height: 1;
            margin-bottom: 1rem;
        }
        .error-message {
            font-size: 1.25rem;
            color: var(--text-color);
            margin-bottom: 1.5rem;
        }
        .btn-home {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s ease-in-out;
        }
        .btn-home:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <div class="error-code">@yield('code')</div>
            <div class="error-message">@yield('message')</div>
            <a href="{{ url('/') }}" class="btn-home">Back to Home</a>
        </div>
    </div>
</body>
</html>
