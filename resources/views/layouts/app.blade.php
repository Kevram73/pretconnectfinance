<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PrêtConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background: #2c3e50;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            transition: all 0.3s;
            border-right: 1px solid #34495e;
        }
        .sidebar .nav-link {
            color: #bdc3c7;
            padding: 15px 20px;
            border-radius: 0;
            margin: 0;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .sidebar .nav-link:hover {
            color: white;
            background-color: #34495e;
            border-left-color: #3498db;
        }
        .sidebar .nav-link.active {
            color: white;
            background-color: #34495e;
            border-left-color: #3498db;
        }
        .main-content {
            margin-left: 250px;
            padding: 0;
            background-color: #f7f7f7;
        }
        .navbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-bottom: 1px solid #e9ecef;
            padding: 15px 30px;
        }
        .card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background: white;
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            border-radius: 8px 8px 0 0 !important;
            padding: 20px;
        }
        .stats-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stats-card .stats-icon {
            font-size: 2.5rem;
            color: #3498db;
        }
        .stats-card .stats-number {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
        }
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
            border-radius: 4px;
            font-weight: 500;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        .btn-success {
            background-color: #27ae60;
            border-color: #27ae60;
        }
        .btn-success:hover {
            background-color: #229954;
            border-color: #229954;
        }
        .btn-warning {
            background-color: #f39c12;
            border-color: #f39c12;
        }
        .btn-warning:hover {
            background-color: #e67e22;
            border-color: #e67e22;
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            font-weight: 600;
            color: #2c3e50;
        }
        .badge {
            border-radius: 4px;
            padding: 6px 12px;
            font-weight: 500;
        }
        .page-title-box {
            background: white;
            padding: 20px 30px;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 30px;
        }
        .page-title {
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
        }
        .container-fluid {
            padding: 0 30px 30px 30px;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .form-control, .form-select {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid #34495e;
            text-align: center;
        }
        .sidebar-brand h4 {
            color: white;
            margin: 0;
            font-weight: 600;
        }
        .user-dropdown {
            background: #f8f9fa;
            border-radius: 4px;
            padding: 8px 15px;
        }
        .user-dropdown .dropdown-toggle {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 500;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .container-fluid {
                padding: 0 15px 15px 15px;
            }
            .page-title-box {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>
                <i class="fas fa-coins me-2"></i>PrêtConnect
            </h4>
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt me-3"></i>Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('deposit.*') ? 'active' : '' }}" href="{{ route('deposit.create') }}">
                <i class="fas fa-plus-circle me-3"></i>Dépôt
            </a>
            <a class="nav-link {{ request()->routeIs('withdrawal.*') ? 'active' : '' }}" href="{{ route('withdrawal.create') }}">
                <i class="fas fa-minus-circle me-3"></i>Retrait
            </a>
            <a class="nav-link {{ request()->routeIs('investments.*') ? 'active' : '' }}" href="{{ route('investments.create') }}">
                <i class="fas fa-chart-line me-3"></i>Investir
            </a>
            <a class="nav-link {{ request()->routeIs('transactions') ? 'active' : '' }}" href="{{ route('transactions') }}">
                <i class="fas fa-exchange-alt me-3"></i>Transactions
            </a>
            <a class="nav-link {{ request()->routeIs('commissions') ? 'active' : '' }}" href="{{ route('commissions') }}">
                <i class="fas fa-handshake me-3"></i>Commissions
            </a>
            <a class="nav-link {{ request()->routeIs('referrals') ? 'active' : '' }}" href="{{ route('referrals') }}">
                <i class="fas fa-users me-3"></i>Parrainage
            </a>
            <a class="nav-link {{ request()->routeIs('team-rewards') ? 'active' : '' }}" href="{{ route('team-rewards') }}">
                <i class="fas fa-trophy me-3"></i>Récompenses
            </a>
            <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                <i class="fas fa-user me-3"></i>Profil
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="btn btn-outline-secondary d-md-none me-3" type="button" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-dropdown" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="fas fa-user me-2"></i>Profil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
    </script>
</body>
</html>