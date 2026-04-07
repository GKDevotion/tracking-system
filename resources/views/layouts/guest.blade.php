<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(ellipse at 20% 20%, rgba(59,130,246,.15) 0%, transparent 50%),
                        radial-gradient(ellipse at 80% 80%, rgba(139,92,246,.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .auth-card {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,.4);
            position: relative;
        }

        .auth-logo {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            margin: 0 auto 1.25rem;
        }

        .auth-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            text-align: center;
            margin-bottom: .35rem;
        }

        .auth-subtitle {
            font-size: .85rem;
            color: #64748b;
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: .875rem;
            padding: .625rem 1rem;
            transition: all .2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59,130,246,.12);
        }

        .form-label {
            font-size: .8rem;
            font-weight: 600;
            color: #374151;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 10px;
            padding: .7rem;
            font-weight: 700;
            font-size: .9rem;
            transition: all .2s;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(59,130,246,.35);
        }

        .input-group-text {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 0 10px 10px 0;
            color: #64748b;
            cursor: pointer;
        }

        .input-group .form-control {
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .otp-input {
            letter-spacing: .5rem;
            font-size: 1.25rem;
            font-weight: 700;
            text-align: center;
        }

        .alert { border-radius: 10px; font-size: .85rem; }

        a { color: var(--primary); text-decoration: none; font-weight: 500; }
        a:hover { color: var(--primary-dark); }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo"><i class="bi bi-geo-alt-fill"></i></div>
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
