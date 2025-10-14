@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Administrateur')
@section('page-subtitle', 'Vue d\'ensemble du système')

@section('content')

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card text-center">
            <div class="stats-icon text-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-number text-primary">{{ \App\Models\User::count() }}</div>
            <div class="stats-label">Total Utilisateurs</div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card text-center">
            <div class="stats-icon text-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-number text-warning">{{ \App\Models\Transaction::where('status', 'PENDING')->count() }}</div>
            <div class="stats-label">Transactions en Attente</div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card text-center">
            <div class="stats-icon text-success">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stats-number text-success">{{ \App\Models\Investment::where('status', 'ACTIVE')->count() }}</div>
            <div class="stats-label">Investissements Actifs</div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card text-center">
            <div class="stats-icon text-info">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stats-number text-info">${{ number_format(\App\Models\Transaction::where('type', 'DEPOSIT')->where('status', 'COMPLETED')->sum('amount'), 2) }}</div>
            <div class="stats-label">Volume Total</div>
        </div>
    </div>
</div>

<!-- Actions Rapides -->
<div class="row">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>Actions Rapides
                </h5>
            </div>
            <div class="admin-card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.transactions') }}" class="btn btn-admin">
                        <i class="fas fa-check-circle me-2"></i>Valider les Transactions
                    </a>
                    <a href="{{ route('admin.users') }}" class="btn btn-admin">
                        <i class="fas fa-user-cog me-2"></i>Gérer les Utilisateurs
                    </a>
                    <a href="{{ route('admin.plans') }}" class="btn btn-admin">
                        <i class="fas fa-coins me-2"></i>Gérer les Plans
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Statistiques Récentes
                </h5>
            </div>
            <div class="admin-card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-success mb-1">{{ \App\Models\Transaction::where('type', 'DEPOSIT')->where('status', 'COMPLETED')->whereDate('created_at', today())->count() }}</h4>
                            <small class="text-muted">Dépôts Aujourd'hui</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-warning mb-1">{{ \App\Models\Transaction::where('type', 'WITHDRAWAL')->where('status', 'COMPLETED')->whereDate('created_at', today())->count() }}</h4>
                        <small class="text-muted">Retraits Aujourd'hui</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection