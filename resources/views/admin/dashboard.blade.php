@extends('layouts.admin')

@section('title', 'Administration - PretConnectLoan')
@section('page-title', 'Tableau de Bord Administrateur')

@section('content')
<!-- Admin Stats -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h3>{{ $stats['total_users'] }}</h3>
                <p class="mb-0">Utilisateurs Totaux</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-user-check fa-2x mb-2"></i>
                <h3>{{ $stats['active_users'] }}</h3>
                <p class="mb-0">Utilisateurs Actifs</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-arrow-up fa-2x mb-2"></i>
                <h3>${{ number_format($stats['total_deposits'], 0) }}</h3>
                <p class="mb-0">Total Dépôts</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-arrow-down fa-2x mb-2"></i>
                <h3>${{ number_format($stats['total_withdrawals'], 0) }}</h3>
                <p class="mb-0">Total Retraits</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-2x mb-2"></i>
                <h3>${{ number_format($stats['total_investments'], 0) }}</h3>
                <p class="mb-0">Total Investissements</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h3>${{ number_format($stats['pending_deposits'], 0) }}</h3>
                <p class="mb-0">Dépôts en Attente</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                <h3>${{ number_format($stats['pending_withdrawals'], 0) }}</h3>
                <p class="mb-0">Retraits en Attente</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-percentage fa-2x mb-2"></i>
                <h3>${{ number_format($stats['total_commissions'], 0) }}</h3>
                <p class="mb-0">Total Commissions</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Actions Rapides
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.users') }}" class="btn btn-primary w-100">
                            <i class="fas fa-users me-2"></i>
                            Gérer les Utilisateurs
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.transactions') }}" class="btn btn-success w-100">
                            <i class="fas fa-exchange-alt me-2"></i>
                            Gérer les Transactions
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.investments') }}" class="btn btn-info w-100">
                            <i class="fas fa-chart-line me-2"></i>
                            Gérer les Investissements
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.plans') }}" class="btn btn-warning w-100">
                            <i class="fas fa-list me-2"></i>
                            Gérer les Plans
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Transactions en Attente
                </h5>
            </div>
            <div class="card-body">
                @php
                    $pendingTransactions = \App\Models\Transaction::pending()->with('user')->latest()->limit(5)->get();
                @endphp
                
                @if($pendingTransactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->user->full_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->type === 'DEPOSIT' ? 'success' : 'warning' }}">
                                            {{ $transaction->type }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($transaction->amount, 2) }}</td>
                                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('admin.transactions', ['status' => 'PENDING']) }}" class="btn btn-outline-primary btn-sm">
                            Voir toutes les transactions en attente
                        </a>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <p class="text-muted mb-0">Aucune transaction en attente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Investissements Actifs
                </h5>
            </div>
            <div class="card-body">
                @php
                    $activeInvestments = \App\Models\Investment::active()->with(['user', 'plan'])->latest()->limit(5)->get();
                @endphp
                
                @if($activeInvestments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Plan</th>
                                    <th>Montant</th>
                                    <th>Profit/Jour</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeInvestments as $investment)
                                <tr>
                                    <td>{{ $investment->user->full_name }}</td>
                                    <td>{{ $investment->plan->name }}</td>
                                    <td>${{ number_format($investment->amount, 2) }}</td>
                                    <td>${{ number_format($investment->daily_profit, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('admin.investments', ['status' => 'ACTIVE']) }}" class="btn btn-outline-primary btn-sm">
                            Voir tous les investissements actifs
                        </a>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Aucun investissement actif</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
