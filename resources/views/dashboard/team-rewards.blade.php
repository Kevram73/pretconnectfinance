@extends('layouts.app')

@section('title', 'Récompenses Équipe - PretConnectLoan')
@section('page-title', 'Récompenses d\'Équipe')

@section('content')
<!-- Team Reward Stats -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-trophy fa-2x mb-2"></i>
                <h3>{{ $teamRewardStats['current_level'] }}</h3>
                <p class="mb-0">Niveau Actuel</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h3>{{ $teamRewardStats['direct_referrals'] }}</h3>
                <p class="mb-0">Filleuls Directs</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-2x mb-2"></i>
                <h3>${{ number_format($teamRewardStats['team_turnover'], 0) }}</h3>
                <p class="mb-0">Chiffre d'Affaires Équipe</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                <h3>${{ number_format($teamRewardStats['total_monthly_salary'], 0) }}</h3>
                <p class="mb-0">Salaire Mensuel Total</p>
            </div>
        </div>
    </div>
</div>

<!-- Team Rewards Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-trophy me-2"></i>
            Progression des Récompenses d'Équipe
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Niveau</th>
                        <th>Titre</th>
                        <th>Filleuls Requis</th>
                        <th>CA Requis</th>
                        <th>Salaire Mensuel</th>
                        <th>Progression</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teamRewards as $reward)
                    <tr class="{{ $reward->status === 'ACHIEVED' ? 'table-success' : ($reward->status === 'MAINTAINED' ? 'table-info' : '') }}">
                        <td>
                            <span class="badge bg-{{ $reward->status === 'ACHIEVED' ? 'success' : ($reward->status === 'MAINTAINED' ? 'info' : 'secondary') }} fs-6">
                                Niveau {{ $reward->level }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $reward->title }}</strong>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="me-2">{{ $reward->current_directs }}/{{ $reward->required_directs }}</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                         style="width: {{ min(100, ($reward->current_directs / $reward->required_directs) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="me-2">${{ number_format($reward->current_turnover, 0) }}/${{ number_format($reward->required_turnover, 0) }}</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ min(100, ($reward->current_turnover / $reward->required_turnover) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-success fw-bold">
                                ${{ number_format($reward->monthly_salary, 0) }}
                            </span>
                        </td>
                        <td>
                            @if($reward->status === 'PENDING')
                                <div class="d-flex align-items-center">
                                    <span class="me-2">{{ round(($reward->current_directs / $reward->required_directs) * 50 + ($reward->current_turnover / $reward->required_turnover) * 50, 1) }}%</span>
                                    <div class="progress flex-grow-1" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" 
                                             style="width: {{ ($reward->current_directs / $reward->required_directs) * 50 + ($reward->current_turnover / $reward->required_turnover) * 50 }}%">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="badge bg-success">100%</span>
                            @endif
                        </td>
                        <td>
                            @if($reward->status === 'ACHIEVED')
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>
                                    Atteint
                                </span>
                            @elseif($reward->status === 'MAINTAINED')
                                <span class="badge bg-info">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Maintenu
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    En Cours
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Team Reward Info -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Comment Fonctionnent les Récompenses d'Équipe
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-target me-2"></i>Objectifs</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Recruter le nombre requis de filleuls directs</li>
                            <li><i class="fas fa-check text-success me-2"></i>Atteindre le chiffre d'affaires d'équipe requis</li>
                            <li><i class="fas fa-check text-success me-2"></i>Maintenir ces objectifs pour continuer à recevoir le salaire</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-gift me-2"></i>Bénéfices</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Salaire mensuel garanti</li>
                            <li><i class="fas fa-check text-success me-2"></i>Reconnaissance et statut</li>
                            <li><i class="fas fa-check text-success me-2"></i>Opportunités de croissance</li>
                        </ul>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Conseil:</strong> Concentrez-vous sur le recrutement de filleuls de qualité qui investissent régulièrement pour atteindre vos objectifs plus rapidement.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
