<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PretConnectLoan - Authentification')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'binance-black': '#0b0e11',
                        'binance-dark': '#161a1e',
                        'binance-darker': '#1e2329',
                        'binance-gray': '#2b3139',
                        'binance-light-gray': '#474d57',
                        'binance-yellow': '#f0b90b',
                        'binance-yellow-hover': '#f8d12d',
                        'binance-green': '#02c076',
                        'binance-red': '#f84960',
                        'binance-blue': '#1890ff',
                        'text-primary': '#eaecef',
                        'text-secondary': '#848e9c',
                        'text-tertiary': '#5e6673',
                        'border-color': '#2b3139',
                        'border-hover': '#474d57',
                    }
                }
            }
        }
    </script>
    
    @yield('styles')
</head>
<body class="min-h-screen bg-gradient-to-br from-binance-black to-binance-dark flex items-center justify-center text-text-primary">
    <div class="w-full max-w-md mx-4">
        <div class="bg-binance-dark border border-binance-yellow rounded-2xl shadow-2xl shadow-binance-yellow/10 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-binance-darker to-binance-dark border-b border-binance-yellow p-8 text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-binance-yellow rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-coins text-xl text-binance-black"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-binance-yellow">PretConnectLoan</h3>
                </div>
                <p class="text-text-secondary">@yield('auth-subtitle', 'Plateforme d\'investissement')</p>
            </div>
            
            <!-- Body -->
            <div class="p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500 rounded-lg text-green-500 flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500 rounded-lg text-red-500 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500 rounded-lg text-red-500">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>
