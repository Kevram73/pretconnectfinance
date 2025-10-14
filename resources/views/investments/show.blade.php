@extends('layouts.app')

@section('title', 'Détails de l\'Investissement')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-eye me-2"></i>Détails de l'Investissement
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations de l'Investissement
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Plan d'investissement</label>
                                <div>
                                    <h5>{{ $investment->plan->name }}</h5>
                                    @if($investment->plan->is_rapid)
                                        <span class="badge bg-warning">RAPIDE</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Montant investi</label>
                                <div>
                                    <h4 class="text-primary">${{ number_format($investment->amount, 2) }}</h4>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Profit quotidien</label>
                                <div>
                                    <h4 class="text-success">${{ number_format($investment->daily_profit, 2) }}</h4>
                                    <small class="text-muted">{{ $investment->daily_percentage }}% par jour</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Statut</label>
                                <div>
                                    @switch($investment->status)
                                        @case('ACTIVE')
                                            <span class="badge bg-success fs-6">
                                                <i class="fas fa-play me-1"></i>Actif
                                            </span>
                                            @break
                                        @case('COMPLETED')
                                            <span class="badge bg-info fs-6">
                                                <i class="fas fa-check me-1"></i>Terminé
                                            </span>
                                            @break
                                        @case('CANCELLED')
                                            <span class="badge bg-danger fs-6">
                                                <i class="fas fa-times me-1"></i>Annulé
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-light text-dark fs-6">{{ $investment->status }}</span>
                                    @endswitch
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Durée</label>
                                <div>
                                    <strong>{{ $investment->duration_days }} jours</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Progression</label>
                                <div>
                                    <strong>{{ $investment->days_elapsed }}/{{ $investment->duration_days }} jours</strong>
                                    @php
                                        $progress = ($investment->days_elapsed / $investment->duration_days) * 100;
                                    @endphp
                                    <div class="progress mt-2">
                                        <div class="progress-bar {{ $progress >= 100 ? 'bg-success' : 'bg-primary' }}" 
                                             role="progressbar" 
                                             style="width: {{ min($progress, 100) }}%">
                                            {{ number_format($progress, 1) }}%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Date de début</label>
                                <div>
                                    <strong>{{ $investment->start_date->format('d/m/Y') }}</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Date de fin</label>
                                <div>
                                    <strong>{{ $investment->end_date->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description du plan</label>
                        <div class="alert alert-light">
                            {{ $investment->plan->description }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calculs de profits -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calculator me-2"></i>Calculs de Profits
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="text-muted">Profit total actuel</h6>
                                <h4 class="text-success">${{ number_format($investment->total_profit, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="text-muted">Profit estimé total</h6>
                                <h4 class="text-info">${{ number_format($investment->amount * ($investment->plan->total_percentage / 100), 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="text-muted">Retour total estimé</h6>
                                <h4 class="text-primary">${{ number_format($investment->amount + ($investment->amount * ($investment->plan->total_percentage / 100)), 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Statistiques du Plan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Montant minimum :</span>
                            <strong>${{ number_format($investment->plan->min_amount, 2) }}</strong>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Montant maximum :</span>
                            <strong>${{ number_format($investment->plan->max_amount, 2) }}</strong>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Pourcentage quotidien :</span>
                            <strong class="text-success">{{ $investment->plan->daily_percentage }}%</strong>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Pourcentage total :</span>
                            <strong class="text-info">{{ $investment->plan->total_percentage }}%</strong>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Type de plan :</span>
                            <strong>{{ $investment->plan->is_rapid ? 'Rapide' : 'Standard' }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Utilisateur
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-circle fa-3x text-muted"></i>
                        </div>
                        <h5>{{ $investment->user->username }}</h5>
                        <p class="text-muted">{{ $investment->user->email }}</p>
                        <p class="text-muted">{{ $investment->user->first_name }} {{ $investment->user->last_name }}</p>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('investments') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Retour aux investissements
                        </a>
                        
                        @if($investment->status === 'ACTIVE')
                        <div class="alert alert-success">
                            <i class="fas fa-play me-2"></i>
                            Votre investissement est actif et génère des profits quotidiens.
                        </div>
                        @elseif($investment->status === 'COMPLETED')
                        <div class="alert alert-info">
                            <i class="fas fa-check me-2"></i>
                            Votre investissement est terminé. Vous pouvez retirer vos profits.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection