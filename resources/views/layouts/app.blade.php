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
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="main-nav">
        <div class="nav-container">
            <a href="{{ route('dashboard') }}" class="logo">
                <i class="fas fa-coins"></i> PretConnect
            </a>
            
            <ul class="nav-menu">
                <li><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
                <li><a href="{{ route('investments.index') }}" class="nav-link">Investissements</a></li>
                <li><a href="{{ route('transactions.index') }}" class="nav-link">Transactions</a></li>
                <li><a href="{{ route('dashboard.referrals') }}" class="nav-link">Équipe</a></li>
            </ul>
            
            <div class="nav-user">
                <div class="user-balance">
                    <span class="text-muted">Solde:</span>
                    <span class="text-gold font-weight-bold">${{ auth()->user()->wallet->balance ?? '0.00' }}</span>
                </div>
                
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle">
                        <i class="fas fa-user"></i>
                        {{ auth()->user()->name }}
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('dashboard.profile') }}" class="dropdown-item">
                            <i class="fas fa-user-edit"></i> Profil
                        </a>
                        <a href="{{ route('logout') }}" class="dropdown-item" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </a>
                    </div>
                </div>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="app-layout">
        @if(isset($sidebar) && $sidebar)
            <aside class="sidebar">
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt sidebar-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('investments.index') }}" class="sidebar-link {{ request()->routeIs('investments.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-line sidebar-icon"></i>
                            Investissements
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('transactions.index') }}" class="sidebar-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                            <i class="fas fa-exchange-alt sidebar-icon"></i>
                            Transactions
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('dashboard.commissions') }}" class="sidebar-link {{ request()->routeIs('dashboard.commissions') ? 'active' : '' }}">
                            <i class="fas fa-percentage sidebar-icon"></i>
                            Commissions
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('dashboard.referrals') }}" class="sidebar-link {{ request()->routeIs('dashboard.referrals') ? 'active' : '' }}">
                            <i class="fas fa-users sidebar-icon"></i>
                            Équipe
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('dashboard.team-rewards') }}" class="sidebar-link {{ request()->routeIs('dashboard.team-rewards') ? 'active' : '' }}">
                            <i class="fas fa-trophy sidebar-icon"></i>
                            Récompenses
                        </a>
                    </li>
                </ul>
            </aside>
        @endif
        
        <main class="main-content" style="margin-left: {{ isset($sidebar) && $sidebar ? '280px' : '0' }}; padding: 2rem;">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success fade-in-up">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger fade-in-up">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger fade-in-up">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const dropdown = this.parentElement;
                    const menu = dropdown.querySelector('.dropdown-menu');
                    
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        if (menu !== this.nextElementSibling) {
                            menu.style.display = 'none';
                        }
                    });
                    
                    // Toggle current dropdown
                    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
                });
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.style.display = 'none';
                    });
                }
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
