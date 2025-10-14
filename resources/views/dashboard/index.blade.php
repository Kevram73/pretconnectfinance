@extends('layouts.app')

@section('title', 'Dashboard - PretConnect Financial')

@php
    $sidebar = true;
@endphp

@section('content')
<div class="dashboard-header mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="fas fa-tachometer-alt text-gold"></i>
                Bonjour, {{ auth()->user()->name }}
            </h1>
            <p class="text-muted">Bienvenue sur votre tableau de bord PretConnect Financial</p>
        </div>
        <div class="quick-actions">
            <a href="{{ route('investments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Nouvel investissement
            </a>
            <a href="{{ route('transactions.deposit') }}" class="btn btn-outline">
                <i class="fas fa-wallet"></i>
                Déposer
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="dashboard-grid fade-in-up">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-wallet"></i>
        </div>
        <div class="stat-value">${{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</div>
        <div class="stat-label">Solde total</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            +5.2% ce mois
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="stat-value">${{ number_format($totalInvestments ?? 0, 2) }}</div>
        <div class="stat-label">Investissements actifs</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            {{ $activeInvestments ?? 0 }} plans
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-percentage"></i>
        </div>
        <div class="stat-value">${{ number_format($totalCommissions ?? 0, 2) }}</div>
        <div class="stat-label">Commissions gagnées</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            +12.8% ce mois
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value">{{ $totalReferrals ?? 0 }}</div>
        <div class="stat-label">Équipe totale</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            {{ $newReferrals ?? 0 }} ce mois
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-5">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-chart-area text-gold"></i>
                        Performance des investissements
                    </h3>
                    <select class="form-control" style="width: auto;">
                        <option>7 derniers jours</option>
                        <option>30 derniers jours</option>
                        <option>3 derniers mois</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="investmentChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-trophy text-gold"></i>
                    Récompenses du mois
                </h3>
            </div>
            <div class="card-body">
                <div class="reward-item">
                    <div class="reward-icon gold">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="reward-info">
                        <div class="reward-title">Top Investisseur</div>
                        <div class="reward-amount">+$500 bonus</div>
                    </div>
                </div>
                
                <div class="reward-item">
                    <div class="reward-icon silver">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="reward-info">
                        <div class="reward-title">Leader d'équipe</div>
                        <div class="reward-amount">+$250 bonus</div>
                    </div>
                </div>
                
                <div class="reward-item">
                    <div class="reward-icon bronze">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="reward-info">
                        <div class="reward-title">Parrain actif</div>
                        <div class="reward-amount">+$100 bonus</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-clock text-gold"></i>
                        Activité récente
                    </h3>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">
                        Voir tout
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="activity-list">
                    @forelse($recentTransactions ?? [] as $transaction)
                    <div class="activity-item">
                        <div class="activity-icon {{ $transaction->type === 'deposit' ? 'success' : 'warning' }}">
                            <i class="fas fa-{{ $transaction->type === 'deposit' ? 'arrow-down' : 'arrow-up' }}"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ ucfirst($transaction->type) }}</div>
                            <div class="activity-time">{{ $transaction->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="activity-amount {{ $transaction->type === 'deposit' ? 'positive' : 'negative' }}">
                            {{ $transaction->type === 'deposit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-history"></i>
                        <p>Aucune activité récente</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bullhorn text-gold"></i>
                    Actualités & Annonces
                </h3>
            </div>
            <div class="card-body">
                <div class="news-item">
                    <div class="news-date">Aujourd'hui</div>
                    <div class="news-title">Nouveau plan d'investissement disponible</div>
                    <div class="news-excerpt">
                        Découvrez notre nouveau plan Premium avec des rendements jusqu'à 15% par mois.
                    </div>
                </div>
                
                <div class="news-item">
                    <div class="news-date">Hier</div>
                    <div class="news-title">Maintenance programmée</div>
                    <div class="news-excerpt">
                        Maintenance de la plateforme prévue le 15/12 de 2h à 4h du matin.
                    </div>
                </div>
                
                <div class="news-item">
                    <div class="news-date">2 jours</div>
                    <div class="news-title">Bonus de parrainage doublé</div>
                    <div class="news-excerpt">
                        Les commissions de parrainage sont doublées jusqu'à la fin du mois !
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .dashboard-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    
    .quick-actions {
        display: flex;
        gap: 1rem;
    }
    
    .stat-card {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(255, 215, 0, 0.15);
    }
    
    .stat-icon {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        width: 50px;
        height: 50px;
        background: rgba(255, 215, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary-gold);
    }
    
    .stat-change {
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .stat-change.positive {
        color: var(--success);
    }
    
    .stat-change.negative {
        color: var(--warning);
    }
    
    .activity-list {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        transition: background 0.3s ease;
    }
    
    .activity-item:hover {
        background: rgba(255, 215, 0, 0.05);
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1rem;
    }
    
    .activity-icon.success {
        background: rgba(35, 134, 54, 0.2);
        color: var(--success);
    }
    
    .activity-icon.warning {
        background: rgba(248, 81, 73, 0.2);
        color: var(--warning);
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }
    
    .activity-time {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }
    
    .activity-amount {
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .activity-amount.positive {
        color: var(--success);
    }
    
    .activity-amount.negative {
        color: var(--warning);
    }
    
    .reward-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .reward-item:last-child {
        border-bottom: none;
    }
    
    .reward-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.25rem;
    }
    
    .reward-icon.gold {
        background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
        color: var(--dark-bg);
    }
    
    .reward-icon.silver {
        background: linear-gradient(135deg, #C0C0C0, #A8A8A8);
        color: var(--dark-bg);
    }
    
    .reward-icon.bronze {
        background: linear-gradient(135deg, #CD7F32, #B87333);
        color: var(--dark-bg);
    }
    
    .reward-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }
    
    .reward-amount {
        color: var(--success);
        font-weight: 700;
    }
    
    .news-item {
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .news-item:last-child {
        border-bottom: none;
    }
    
    .news-date {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }
    
    .news-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    
    .news-excerpt {
        color: var(--text-secondary);
        line-height: 1.5;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-secondary);
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .row {
        display: flex;
        margin: 0 -1rem;
    }
    
    .col-lg-4, .col-lg-5, .col-lg-7, .col-lg-8 {
        padding: 0 1rem;
        margin-bottom: 2rem;
    }
    
    .col-lg-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
    
    .col-lg-5 {
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }
    
    .col-lg-7 {
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
    }
    
    .col-lg-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }
    
    @media (max-width: 768px) {
        .col-lg-4, .col-lg-5, .col-lg-7, .col-lg-8 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .quick-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .dashboard-title {
            font-size: 1.75rem;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Investment Chart
        const ctx = document.getElementById('investmentChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                    datasets: [{
                        label: 'Rendements ($)',
                        data: [120, 190, 300, 500, 420, 680, 750],
                        borderColor: '#FFD700',
                        backgroundColor: 'rgba(255, 215, 0, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#FFD700',
                        pointBorderColor: '#FFA500',
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#8B949E',
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#8B949E'
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverBackgroundColor: '#FFD700'
                        }
                    }
                }
            });
        }
        
        // Auto-refresh data every 30 seconds
        setInterval(function() {
            // Refresh dashboard data via AJAX
            // Implementation would go here
        }, 30000);
    });
</script>
@endsection
