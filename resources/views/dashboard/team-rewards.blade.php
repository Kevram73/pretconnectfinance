@extends('layouts.app')

@section('title', 'Récompenses d\'Équipe')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-trophy me-2"></i>Récompenses d'Équipe
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Mes Récompenses d'Équipe
                    </h5>
                </div>
                <div class="card-body">
                    @if($teamRewards->count() > 0)
                        <div class="row">
                            @foreach($teamRewards as $reward)
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header {{ $reward->status === 'ACHIEVED' ? 'bg-success' : ($reward->status === 'MAINTAINED' ? 'bg-info' : 'bg-warning') }} text-white">
                                        <h5 class="card-title mb-0 text-center">
                                            {{ $reward->title }}
                                            @if($reward->status === 'ACHIEVED')
                                                <i class="fas fa-check-circle ms-2"></i>
                                            @elseif($reward->status === 'MAINTAINED')
                                                <i class="fas fa-star ms-2"></i>
                                            @else
                                                <i class="fas fa-clock ms-2"></i>
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <h4 class="text-primary">${{ number_format($reward->monthly_salary, 2) }}</h4>
                                            <small class="text-muted">Salaire mensuel</small>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <h6 class="text-muted">Directs requis</h6>
                                                <h5>{{ $reward->required_directs }}</h5>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-muted">CA requis</h6>
                                                <h5>${{ number_format($reward->required_turnover, 0) }}</h5>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <h6 class="text-muted">Vos directs</h6>
                                                <h5 class="{{ $reward->current_directs >= $reward->required_directs ? 'text-success' : 'text-warning' }}">
                                                    {{ $reward->current_directs }}
                                                </h5>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-muted">Votre CA</h6>
                                                <h5 class="{{ $reward->current_turnover >= $reward->required_turnover ? 'text-success' : 'text-warning' }}">
                                                    ${{ number_format($reward->current_turnover, 0) }}
                                                </h5>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            @switch($reward->status)
                                                @case('PENDING')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>En cours
                                                    </span>
                                                    @break
                                                @case('ACHIEVED')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Atteint
                                                    </span>
                                                    @break
                                                @case('MAINTAINED')
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-star me-1"></i>Maintenu
                                                    </span>
                                                    @break
                                            @endswitch
                                        </div>
                                        
                                        @if($reward->achieved_at)
                                            <small class="text-muted">
                                                Atteint le {{ $reward->achieved_at->format('d/m/Y') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune récompense d'équipe</h5>
                            <p class="text-muted">Développez votre équipe pour débloquer des récompenses !</p>
                            <a href="{{ route('referrals') }}" class="btn btn-primary">
                                <i class="fas fa-users me-2"></i>Voir le Parrainage
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Niveaux de Récompenses Disponibles -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-star me-2"></i>Niveaux de Récompenses Disponibles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Chef d'équipe</h6>
                                    <h4 class="text-primary">$150/mois</h4>
                                    <p class="small text-muted">5 directs + $5,000 CA</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Superviseur</h6>
                                    <h4 class="text-success">$300</h4>
                                    <p class="small text-muted">10 directs + $10,000 CA</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Manager</h6>
                                    <h4 class="text-info">$450</h4>
                                    <p class="small text-muted">15 directs + $15,000 CA</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Directeur</h6>
                                    <h4 class="text-warning">$1,000</h4>
                                    <p class="small text-muted">25 directs + $25,000 CA</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-danger">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Directeur Senior</h6>
                                    <h4 class="text-danger">$2,000/mois</h4>
                                    <p class="small text-muted">50 directs + $50,000 CA</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-dark">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Vice-Président</h6>
                                    <h4 class="text-dark">$5,000</h4>
                                    <p class="small text-muted">110 directs + $100,000 CA</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-dark">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Président</h6>
                                    <h4 class="text-dark">$20,000</h4>
                                    <p class="small text-muted">120 directs + $240,000 CA</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-dark">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Président</h6>
                                    <h4 class="text-dark">$20,000</h4>
                                    <p class="small text-muted">150 directs + $400,000 CA</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card" style="border: 2px solid #667eea; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Président</h6>
                                    <h4>$50,000/mois</h4>
                                    <p class="small">200 directs + $1,000,000 CA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection