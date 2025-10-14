<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .admin-sidebar {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .admin-sidebar .nav-link {
            color: #b8c5d6;
            padding: 15px 25px;
            border-radius: 0;
            margin: 0;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            font-weight: 500;
        }
        .admin-sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left-color: #00d4ff;
        }
        .admin-sidebar .nav-link.active {
            color: white;
            background-color: rgba(0,212,255,0.2);
            border-left-color: #00d4ff;
        }
        .admin-main-content {
            margin-left: 280px;
            padding: 0;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .admin-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-bottom: 1px solid #e9ecef;
            padding: 15px 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .admin-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            background: white;
            margin-bottom: 25px;
        }
        .admin-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 20px 25px;
            border: none;
        }
        .admin-card-header h5 {
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .admin-card-body {
            padding: 25px;
        }
        .stats-card {
            background: white;
            border: none;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-card .stats-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .stats-card .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .stats-card .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .btn-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-admin-success {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
        }
        .btn-admin-danger {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
        }
        .btn-admin-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .btn-admin-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .page-title-box {
            background: white;
            padding: 25px 30px;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .page-title {
            color: #2c3e50;
            font-weight: 700;
            margin: 0;
            font-size: 1.8rem;
        }
        .page-subtitle {
            color: #6c757d;
            margin: 5px 0 0 0;
            font-size: 1rem;
        }
        .container-fluid {
            padding: 0 30px 30px 30px;
        }
        .sidebar-brand {
            padding: 25px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        .sidebar-brand h4 {
            color: white;
            margin: 0;
            font-weight: 700;
            font-size: 1.3rem;
        }
        .sidebar-brand .brand-icon {
            color: #00d4ff;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        .user-dropdown {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 8px 15px;
        }
        .user-dropdown .dropdown-toggle {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 600;
        }
        .table-admin {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .table-admin th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
        }
        .table-admin td {
            padding: 15px;
            border-color: #f1f3f4;
        }
        .badge-admin {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }
        .badge-success-admin {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
            color: white;
        }
        .badge-warning-admin {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .badge-danger-admin {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            color: white;
        }
        .badge-info-admin {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        .badge-primary-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .form-control-admin {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control-admin:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .alert-admin {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
        }
        .modal-admin .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .modal-admin .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0;
            border: none;
        }
        .modal-admin .modal-title {
            font-weight: 600;
        }
        .modal-admin .btn-close {
            filter: invert(1);
        }
        .nav-section {
            margin: 20px 0;
        }
        .nav-section-title {
            color: #6c757d;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 25px;
            margin: 0;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: #6c757d;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 6px;
            margin: 0 2px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none !important;
            color: white !important;
        }
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-main-content {
                margin-left: 0;
            }
            .container-fluid {
                padding: 0 15px 15px 15px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Admin Sidebar -->
    <div class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h4>Admin Panel</h4>
        </div>
        
        <nav class="nav flex-column">
            <div class="nav-section">
                <p class="nav-section-title">Tableau de Bord</p>
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                </a>
            </div>

            <div class="nav-section">
                <p class="nav-section-title">Gestion</p>
                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                    <i class="fas fa-users me-3"></i>Utilisateurs
                </a>
                <a class="nav-link {{ request()->routeIs('admin.transactions*') ? 'active' : '' }}" href="{{ route('admin.transactions') }}">
                    <i class="fas fa-exchange-alt me-3"></i>Transactions
                </a>
                <a class="nav-link {{ request()->routeIs('admin.investments*') ? 'active' : '' }}" href="{{ route('admin.investments') }}">
                    <i class="fas fa-chart-line me-3"></i>Investissements
                </a>
                <a class="nav-link {{ request()->routeIs('admin.plans*') ? 'active' : '' }}" href="{{ route('admin.plans') }}">
                    <i class="fas fa-coins me-3"></i>Plans
                </a>
                <a class="nav-link {{ request()->routeIs('admin.commissions*') ? 'active' : '' }}" href="{{ route('admin.commissions') }}">
                    <i class="fas fa-handshake me-3"></i>Commissions
                </a>
                <a class="nav-link {{ request()->routeIs('admin.team-rewards*') ? 'active' : '' }}" href="{{ route('admin.team-rewards') }}">
                    <i class="fas fa-trophy me-3"></i>Récompenses
                </a>
                <a class="nav-link {{ request()->routeIs('admin.wallets*') ? 'active' : '' }}" href="{{ route('admin.wallets') }}">
                    <i class="fas fa-wallet me-3"></i>Portefeuilles
                </a>
            </div>

            <div class="nav-section">
                <p class="nav-section-title">Système</p>
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-user me-3"></i>Vue Utilisateur
                </a>
                <a class="nav-link" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-3"></i>Déconnexion
                </a>
            </div>
        </nav>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Main Content -->
    <div class="admin-main-content">
        <!-- Top Navbar -->
        <nav class="admin-navbar">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary d-md-none me-3" type="button" onclick="toggleSidebar()">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div>
                            <h5 class="mb-0">@yield('page-title', 'Administration')</h5>
                            <small class="text-muted">@yield('page-subtitle', 'Panel d\'administration')</small>
                        </div>
                    </div>
                    
                    <div class="navbar-nav">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-shield me-2"></i>{{ Auth::user()->username }} (Admin)
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-user me-2"></i>Vue Utilisateur
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-admin alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-admin alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-admin alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-admin alert-dismissible fade show">
                    <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            sidebar.classList.toggle('show');
        }

        // Initialize DataTables
        $(document).ready(function() {
            $('.data-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
                },
                "pageLength": 25,
                "responsive": true,
                "order": [[ 0, "desc" ]],
                "columnDefs": [
                    { "orderable": false, "targets": -1 }
                ]
            });
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>