@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </h4>
            </div>
        </div>
    </div>

    <!-- Statistiques du portefeuille -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Solde Actuel</h6>
                        <h3 class="stats-number mb-0">${{ number_format($stats['balance'], 2) }}</h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Déposé</h6>
                        <h3 class="stats-number mb-0">${{ number_format($stats['total_deposited'], 2) }}</h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Investi</h6>
                        <h3 class="stats-number mb-0">${{ number_format($stats['total_invested'], 2) }}</h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Profits</h6>
                        <h3 class="stats-number mb-0">${{ number_format($stats['total_profits'], 2) }}</h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Investissements Actifs -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Investissements Actifs
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
                                        <th>Profit/Jour</th>
                                        <th>Durée</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeInvestments as $investment)
                                    <tr>
                                        <td>
                                            <strong>{{ $investment->plan->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $investment->plan->description }}</small>
                                        </td>
                                        <td>${{ number_format($investment->amount, 2) }}</td>
                                        <td>
                                            <span class="text-success">${{ number_format($investment->daily_profit, 2) }}</span>
                                            <br>
                                            <small class="text-muted">{{ $investment->daily_percentage }}%</small>
                                        </td>
                                        <td>
                                            {{ $investment->days_elapsed }}/{{ $investment->duration_days }} jours
                                            <br>
                                            <small class="text-muted">Fin: {{ $investment->end_date->format('d/m/Y') }}</small>
                                        </td>
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
                            <h5 class="text-muted">Aucun investissement actif</h5>
                            <p class="text-muted">Commencez à investir pour voir vos investissements ici.</p>
                            <a href="{{ route('investments.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Investir Maintenant
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions Rapides -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Actions Rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('deposit.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle me-2"></i>Déposer des fonds
                        </a>
                        <a href="{{ route('withdrawal.create') }}" class="btn btn-warning">
                            <i class="fas fa-minus-circle me-2"></i>Retirer des fonds
                        </a>
                        <a href="{{ route('investments.create') }}" class="btn btn-primary">
                            <i class="fas fa-chart-line me-2"></i>Investir
                        </a>
                        <a href="{{ route('referrals') }}" class="btn btn-info">
                            <i class="fas fa-users me-2"></i>Parrainer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Code de Parrainage -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-handshake me-2"></i>Votre Code de Parrainage
                    </h5>
                </div>
                <div class="card-body text-center">
                    <h4 class="text-primary mb-3">{{ Auth::user()->referral_code }}</h4>
                    <p class="text-muted mb-3">Partagez ce code avec vos amis pour gagner des commissions !</p>
                    <button class="btn btn-outline-primary" onclick="copyReferralCode()">
                        <i class="fas fa-copy me-2"></i>Copier le code
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Récentes -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exchange-alt me-2"></i>Transactions Récentes
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
                                            @switch($transaction->type)
                                                @case('DEPOSIT')
                                                    <span class="badge bg-success">Dépôt</span>
                                                    @break
                                                @case('WITHDRAWAL')
                                                    <span class="badge bg-warning">Retrait</span>
                                                    @break
                                                @case('INVESTMENT')
                                                    <span class="badge bg-primary">Investissement</span>
                                                    @break
                                                @case('PROFIT')
                                                    <span class="badge bg-info">Profit</span>
                                                    @break
                                                @case('COMMISSION')
                                                    <span class="badge bg-secondary">Commission</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">{{ $transaction->type }}</span>
                                            @endswitch
                                        </td>
                                        <td>${{ number_format($transaction->amount, 2) }}</td>
                                        <td>
                                            @switch($transaction->status)
                                                @case('PENDING')
                                                    <span class="badge bg-warning">En attente</span>
                                                    @break
                                                @case('COMPLETED')
                                                    <span class="badge bg-success">Complété</span>
                                                    @break
                                                @case('CANCELLED')
                                                    <span class="badge bg-danger">Annulé</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">{{ $transaction->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('transactions') }}" class="btn btn-outline-primary btn-sm">
                                Voir toutes les transactions
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-exchange-alt fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Aucune transaction récente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Commissions Récentes -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-handshake me-2"></i>Commissions Récentes
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentCommissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Filleul</th>
                                        <th>Montant</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentCommissions as $commission)
                                    <tr>
                                        <td>
                                            <strong>{{ $commission->user->username }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $commission->user->email }}</small>
                                        </td>
                                        <td>
                                            <span class="text-success">${{ number_format($commission->amount, 2) }}</span>
                                            <br>
                                            <small class="text-muted">{{ $commission->percentage }}%</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $commission->type }}</span>
                                        </td>
                                        <td>{{ $commission->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('commissions') }}" class="btn btn-outline-primary btn-sm">
                                Voir toutes les commissions
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-handshake fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Aucune commission récente</p>
                            <small class="text-muted">Parrainez des amis pour gagner des commissions !</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyReferralCode() {
    const referralCode = '{{ Auth::user()->referral_code }}';
    navigator.clipboard.writeText(referralCode).then(function() {
        // Afficher une notification de succès
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check me-2"></i>Copié !';
        button.classList.remove('btn-outline-primary');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-primary');
        }, 2000);
    });
}
</script>
@endsection