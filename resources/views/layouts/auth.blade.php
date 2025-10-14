<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'PretConnect Financial')</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1a1f2e 100%);
            position: relative;
            overflow: hidden;
        }
        
        .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23FFD700" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="%23FFA500" opacity="0.03"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .auth-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            position: relative;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .auth-logo {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-gold);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .auth-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }
        
        .auth-form .form-group {
            margin-bottom: 1.5rem;
        }
        
        .auth-form .btn {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            margin-top: 1rem;
        }
        
        .auth-links {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }
        
        .auth-links a {
            color: var(--primary-gold);
            text-decoration: none;
            font-weight: 500;
        }
        
        .auth-links a:hover {
            text-decoration: underline;
        }
        
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .floating-shapes .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-shapes .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-shapes .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        
        .floating-shapes .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .alert {
            background: var(--card-bg);
            border: 1px solid;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-success {
            border-color: var(--success);
            color: var(--success);
        }
        
        .alert-danger {
            border-color: var(--warning);
            color: var(--warning);
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="auth-container">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="auth-card fade-in-up">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-coins"></i> PretConnect
                </div>
                <p class="auth-subtitle">@yield('subtitle', 'Plateforme d\'investissement financier')</p>
            </div>
            
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>
