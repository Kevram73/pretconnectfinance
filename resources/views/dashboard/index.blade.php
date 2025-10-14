@extends('layouts.app')

@section('title', 'Dashboard - PretConnectLoan')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-wallet fa-2x mb-2"></i>
                <h3>${{ number_format($user->wallet->balance, 2) }}</h3>
                <p class="mb-0">Solde Principal</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-arrow-up fa-2x mb-2"></i>
                <h3>${{ number_format($user->wallet->total_deposited, 2) }}</h3>
                <p class="mb-0">Total Dépôts</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-2x mb-2"></i>
                <h3>${{ number_format($investmentStats['total_invested'], 2) }}</h3>
                <p class="mb-0">Total Investi</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-percentage fa-2x mb-2"></i>
                <h3>${{ number_format($commissionStats['total_commissions'], 2) }}</h3>
                <p class="mb-0">Total Commissions</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Actions -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Actions Rapides
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('deposit.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>
                        Faire un Dépôt
                    </a>
                    <a href="{{ route('withdrawal.create') }}" class="btn btn-warning">
                        <i class="fas fa-minus me-2"></i>
                        Demander un Retrait
                    </a>
                    <a href="{{ route('investments.create') }}" class="btn btn-primary">
                        <i class="fas fa-chart-line me-2"></i>
                        Nouvel Investissement
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Investments -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Investissements Actifs
                </h5>
            </div>
            <div class="card-body">
                @if($activeInvestments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Montant</th>
                                    <th>Profit Quotidien</th>
                                    <th>Durée</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeInvestments as $investment)
                                <tr>
                                    <td>{{ $investment->plan->name }}</td>
                                    <td>${{ number_format($investment->amount, 2) }}</td>
                                    <td>${{ number_format($investment->daily_profit, 2) }}</td>
                                    <td>{{ $investment->days_elapsed }}/{{ $investment->duration_days }} jours</td>
                                    <td>
                                        <span class="badge bg-success">{{ $investment->status }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucun investissement actif</p>
                        <a href="{{ route('investments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Créer un investissement
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Transactions -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    Transactions Récentes
                </h5>
            </div>
            <div class="card-body">
                @if($recentTransactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTransactions as $transaction)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $transaction->type === 'DEPOSIT' ? 'success' : ($transaction->type === 'WITHDRAWAL' ? 'warning' : 'primary') }}">
                                            {{ $transaction->type }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($transaction->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->status === 'COMPLETED' ? 'success' : ($transaction->status === 'PENDING' ? 'warning' : 'danger') }}">
                                            {{ $transaction->status }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('transactions') }}" class="btn btn-outline-primary btn-sm">
                            Voir toutes les transactions
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune transaction récente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Available Plans -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Plans Disponibles
                </h5>
            </div>
            <div class="card-body">
                @if($availablePlans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Min/Max</th>
                                    <th>% Quotidien</th>
                                    <th>Durée</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availablePlans as $plan)
                                <tr>
                                    <td>{{ $plan->name }}</td>
                                    <td>${{ number_format($plan->min_amount) }}/${{ number_format($plan->max_amount) }}</td>
                                    <td>{{ $plan->daily_percentage }}%</td>
                                    <td>{{ $plan->duration_days }} jours</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('investments.create') }}" class="btn btn-outline-primary btn-sm">
                            Investir maintenant
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucun plan disponible</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- User Info -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informations du Compte
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nom complet:</strong> {{ $user->full_name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Nom d'utilisateur:</strong> {{ $user->username }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Code de parrainage:</strong> <code>{{ $user->referral_code }}</code></p>
                        <p><strong>Membre depuis:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                        <p><strong>Statut:</strong> 
                            <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
