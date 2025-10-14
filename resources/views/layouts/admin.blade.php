<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration - PretConnectLoan')</title>
    
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
</head>
<body class="bg-binance-black text-text-primary font-sans">
            <!-- Sidebar -->
    <nav class="fixed left-0 top-0 h-screen w-60 bg-binance-dark border-r border-border-color z-50 transition-all duration-300">
        <div class="flex items-center p-4 border-b border-border-color mb-4">
            <div class="w-8 h-8 bg-binance-yellow rounded-md flex items-center justify-center mr-3 font-bold text-binance-black">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="text-lg font-bold text-text-primary">Admin Panel</div>
                    </div>
                    
        <ul class="space-y-1 px-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-binance-darker rounded-md transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-binance-yellow bg-binance-darker font-semibold' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 mr-3 text-center"></i>
                                Tableau de Bord
                            </a>
                        </li>
            <li>
                <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-binance-darker rounded-md transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'text-binance-yellow bg-binance-darker font-semibold' : '' }}">
                    <i class="fas fa-users w-5 mr-3 text-center"></i>
                                Utilisateurs
                            </a>
                        </li>
            <li>
                <a href="{{ route('admin.transactions') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-binance-darker rounded-md transition-all duration-200 {{ request()->routeIs('admin.transactions*') ? 'text-binance-yellow bg-binance-darker font-semibold' : '' }}">
                    <i class="fas fa-exchange-alt w-5 mr-3 text-center"></i>
                                Transactions
                            </a>
                        </li>
            <li>
                <a href="{{ route('admin.investments') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-binance-darker rounded-md transition-all duration-200 {{ request()->routeIs('admin.investments*') ? 'text-binance-yellow bg-binance-darker font-semibold' : '' }}">
                    <i class="fas fa-chart-line w-5 mr-3 text-center"></i>
                                Investissements
                            </a>
                        </li>
            <li>
                <a href="{{ route('admin.plans') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-binance-darker rounded-md transition-all duration-200 {{ request()->routeIs('admin.plans*') ? 'text-binance-yellow bg-binance-darker font-semibold' : '' }}">
                    <i class="fas fa-list w-5 mr-3 text-center"></i>
                                Plans
                            </a>
                        </li>
            <li>
                <a href="{{ route('admin.commissions') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-binance-darker rounded-md transition-all duration-200 {{ request()->routeIs('admin.commissions*') ? 'text-binance-yellow bg-binance-darker font-semibold' : '' }}">
                    <i class="fas fa-percentage w-5 mr-3 text-center"></i>
                                Commissions
                            </a>
                        </li>
                    </ul>
                    
        <hr class="border-border-color my-4">
        
        <ul class="space-y-1 px-2">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-binance-darker rounded-md transition-all duration-200">
                    <i class="fas fa-arrow-left w-5 mr-3 text-center"></i>
                                Retour au Site
                            </a>
                        </li>
            <li>
                <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                    <button type="submit" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-binance-darker rounded-md transition-all duration-200 w-full text-left">
                        <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                                    Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
            </nav>

            <!-- Main content -->
    <main class="ml-60 min-h-screen bg-binance-black">
        <!-- Top Navigation -->
        <div class="sticky top-0 z-40 bg-binance-dark border-b border-border-color px-6 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-semibold text-text-primary">@yield('page-title', 'Administration')</h1>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-binance-yellow rounded-full flex items-center justify-center mr-3 font-semibold text-xs text-binance-black">
                        {{ substr(auth()->user()->full_name, 0, 1) }}
                    </div>
                    <span class="text-text-secondary">{{ auth()->user()->full_name }}</span>
                </div>
                    </div>
                </div>

        <!-- Content Wrapper -->
        <div class="p-6">
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-500/10 border border-green-500 rounded-lg text-green-500 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                <div class="mb-4 p-4 bg-red-500/10 border border-red-500 rounded-lg text-red-500 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                <div class="mb-4 p-4 bg-red-500/10 border border-red-500 rounded-lg text-red-500">
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
    </main>
    
    @yield('scripts')
</body>
</html>
